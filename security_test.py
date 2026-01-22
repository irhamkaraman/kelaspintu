#!/usr/bin/env python3
"""
Security Test Script for KelasPintu (Updated with CSRF Token Handling)
Tests rate limiting and security features by attempting to:
1. Register multiple accounts
2. Create multiple classes repeatedly
3. Verify rate limiting is working correctly

Expected Results:
- Registration should be blocked after 5 attempts (24h limit)
- Class creation should be blocked after 3 attempts (48h limit)
"""

import requests
import time
import random
import string
from datetime import datetime
from bs4 import BeautifulSoup

# Configuration
BASE_URL = "https://kelaspintu.lik.my.id"
REGISTER_URL = f"{BASE_URL}/register"
LOGIN_URL = f"{BASE_URL}/login"
CREATE_CLASS_URL = f"{BASE_URL}/kelas"

# Helper functions
def extract_csrf_token(html_content):
    """Extract CSRF token from HTML"""
    try:
        soup = BeautifulSoup(html_content, 'html.parser')
        token_input = soup.find('input', {'name': '_token'})
        if token_input:
            return token_input.get('value')
        
        # Alternative: try meta tag
        meta_token = soup.find('meta', {'name': 'csrf-token'})
        if meta_token:
            return meta_token.get('content')
            
        return None
    except Exception as e:
        print(f"   Error extracting CSRF token: {e}")
        return None

def generate_random_email():
    """Generate random email for testing"""
    random_str = ''.join(random.choices(string.ascii_lowercase + string.digits, k=8))
    return f"test_{random_str}@example.com"

def generate_random_name():
    """Generate random name for testing"""
    first_names = ["Ahmad", "Budi", "Citra", "Dewi", "Eko", "Fitri", "Gita", "Hadi"]
    last_names = ["Santoso", "Wijaya", "Pratama", "Kusuma", "Putra", "Sari", "Lestari"]
    return f"{random.choice(first_names)} {random.choice(last_names)}"

def generate_class_name():
    """Generate random class name"""
    subjects = ["Pemrograman", "Database", "Networking", "Security", "AI", "ML", "Web Dev"]
    levels = ["Dasar", "Lanjut", "Expert", "Pro"]
    return f"{random.choice(subjects)} {random.choice(levels)} {random.randint(1, 99)}"

# Test functions
def test_registration_rate_limit():
    """
    Test registration rate limiting (5 per 24 hours)
    Expected: First 5 succeed, 6th should return 429
    """
    print("\n" + "="*60)
    print("TEST 1: Registration Rate Limiting (5 per 24h)")
    print("="*60)
    
    results = []
    
    for i in range(7):  # Try 7 registrations
        print(f"\n[{i+1}/7] Attempting registration...")
        
        session = requests.Session()
        
        try:
            # Get registration page and CSRF token
            print("   → Getting CSRF token...")
            response = session.get(REGISTER_URL)
            csrf_token = extract_csrf_token(response.text)
            
            if not csrf_token:
                print("   ⚠ Could not extract CSRF token")
                results.append({'attempt': i + 1, 'status': 'NO_TOKEN', 'success': False})
                continue
            
            print(f"   → CSRF token: {csrf_token[:20]}...")
            
            # Prepare registration data
            data = {
                '_token': csrf_token,
                'name': generate_random_name(),
                'email': generate_random_email(),
                'password': 'Test123!@#',
                'password_confirmation': 'Test123!@#',
            }
            
            # Submit registration
            response = session.post(REGISTER_URL, data=data, allow_redirects=False)
            
            status = response.status_code
            results.append({
                'attempt': i + 1,
                'status': status,
                'success': status in [200, 201, 302]
            })
            
            print(f"   Status: {status}")
            if status == 429:
                print(f"   ✅ RATE LIMIT TRIGGERED! (Expected after 5 attempts)")
                try:
                    error_data = response.json()
                    print(f"   Message: {error_data.get('message', 'N/A')}")
                except:
                    pass
            elif status in [200, 201, 302]:
                print(f"   ✓ Registration successful")
            elif status == 422:
                print(f"   ⚠ Validation error (check if email unique)")
            else:
                print(f"   ⚠ Unexpected status: {status}")
                
        except Exception as e:
            print(f"   ❌ Error: {str(e)}")
            results.append({
                'attempt': i + 1,
                'status': 'ERROR',
                'success': False
            })
        
        time.sleep(1)  # Small delay between requests
    
    # Summary
    print("\n" + "-"*60)
    print("REGISTRATION TEST SUMMARY:")
    successful = sum(1 for r in results if r['success'])
    rate_limited = sum(1 for r in results if r['status'] == 429)
    print(f"  Successful registrations: {successful}")
    print(f"  Rate limited (429): {rate_limited}")
    print(f"  Expected: ~5 successful, ~2 rate limited")
    
    if rate_limited >= 1:
        print("  ✅ RATE LIMITING IS WORKING!")
    else:
        print("  ⚠ WARNING: No rate limiting detected!")
    
    return results

def test_class_creation_rate_limit():
    """
    Test class creation rate limiting (3 per 48 hours)
    Expected: First 3 succeed, 4th should return 429
    """
    print("\n" + "="*60)
    print("TEST 2: Class Creation Rate Limiting (3 per 48h)")
    print("="*60)
    
    session = requests.Session()
    
    print("\n[Step 1] Logging in with test account...")
    
    try:
        # Get login page and CSRF token
        print("   → Getting login page...")
        response = session.get(LOGIN_URL)
        csrf_token = extract_csrf_token(response.text)
        
        if not csrf_token:
            print("   ❌ Could not extract CSRF token from login page")
            return []
        
        print(f"   → CSRF token: {csrf_token[:20]}...")
        
        # Attempt login
        login_data = {
            '_token': csrf_token,
            'email': 'budi@example.com',
            'password': 'password123'
        }
        
        response = session.post(LOGIN_URL, data=login_data, allow_redirects=False)
        
        if response.status_code not in [200, 302]:
            print(f"   ❌ Login failed with status {response.status_code}")
            return []
        
        print("   ✓ Login successful")
        
    except Exception as e:
        print(f"   ❌ Login error: {str(e)}")
        return []
    
    # Now try creating classes
    print("\n[Step 2] Attempting to create classes...")
    results = []
    
    for i in range(5):  # Try 5 class creations
        print(f"\n[{i+1}/5] Creating class...")
        
        try:
            # Get create page and CSRF token
            print("   → Getting create page...")
            response = session.get(f"{BASE_URL}/kelas/create")
            csrf_token = extract_csrf_token(response.text)
            
            if not csrf_token:
                print("   ⚠ Could not extract CSRF token")
                continue
            
            print(f"   → CSRF token: {csrf_token[:20]}...")
            
            # Prepare class data
            data = {
                '_token': csrf_token,
                'nama': generate_class_name(),
                'deskripsi': f'Test class for security testing - {datetime.now()}'
            }
            
            # Submit class creation
            response = session.post(CREATE_CLASS_URL, data=data, allow_redirects=False)
            
            status = response.status_code
            results.append({
                'attempt': i + 1,
                'status': status,
                'success': status in [200, 201, 302]
            })
            
            print(f"   Status: {status}")
            if status == 429:
                print(f"   ✅ RATE LIMIT TRIGGERED! (Expected after 3 attempts)")
                try:
                    error_data = response.json()
                    print(f"   Message: {error_data.get('message', 'N/A')}")
                    print(f"   Retry after: {error_data.get('retry_after', 'N/A')}")
                except:
                    pass
            elif status in [200, 201, 302]:
                print(f"   ✓ Class created successfully")
            elif status == 422:
                print(f"   ⚠ Validation error")
            else:
                print(f"   ⚠ Unexpected status: {status}")
                
        except Exception as e:
            print(f"   ❌ Error: {str(e)}")
            results.append({
                'attempt': i + 1,
                'status': 'ERROR',
                'success': False
            })
        
        time.sleep(1)
    
    # Summary
    print("\n" + "-"*60)
    print("CLASS CREATION TEST SUMMARY:")
    successful = sum(1 for r in results if r['success'])
    rate_limited = sum(1 for r in results if r['status'] == 429)
    print(f"  Successful creations: {successful}")
    print(f"  Rate limited (429): {rate_limited}")
    print(f"  Expected: ~3 successful, ~2 rate limited")
    
    if rate_limited >= 1:
        print("  ✅ RATE LIMITING IS WORKING!")
    else:
        print("  ⚠ WARNING: No rate limiting detected!")
    
    return results

def test_input_validation():
    """
    Test input validation and sanitization
    """
    print("\n" + "="*60)
    print("TEST 3: Input Validation & XSS Protection")
    print("="*60)
    
    session = requests.Session()
    
    # Login first
    print("\n[Step 1] Logging in...")
    try:
        response = session.get(LOGIN_URL)
        csrf_token = extract_csrf_token(response.text)
        
        if not csrf_token:
            print("   ❌ Could not get CSRF token")
            return []
        
        login_data = {
            '_token': csrf_token,
            'email': 'budi@example.com',
            'password': 'password123'
        }
        session.post(LOGIN_URL, data=login_data)
        print("   ✓ Logged in")
        
    except Exception as e:
        print(f"   ❌ Login error: {str(e)}")
        return []
    
    print("\n[Step 2] Testing malicious inputs...")
    
    test_cases = [
        {
            'name': 'XSS Script Tag',
            'data': {
                'nama': '<script>alert("XSS")</script>',
                'deskripsi': 'Normal description'
            }
        },
        {
            'name': 'SQL Injection',
            'data': {
                'nama': "'; DROP TABLE kelas; --",
                'deskripsi': 'Normal description'
            }
        },
        {
            'name': 'Special Characters',
            'data': {
                'nama': 'Test@#$%^&*()Class',
                'deskripsi': 'Normal description'
            }
        },
        {
            'name': 'Too Long Name',
            'data': {
                'nama': 'A' * 200,  # Exceeds 100 char limit
                'deskripsi': 'Normal description'
            }
        }
    ]
    
    results = []
    for test in test_cases:
        print(f"\n  Testing: {test['name']}")
        try:
            # Get CSRF token
            response = session.get(f"{BASE_URL}/kelas/create")
            csrf_token = extract_csrf_token(response.text)
            
            if not csrf_token:
                print(f"    ⚠ Could not get CSRF token")
                continue
            
            # Add CSRF token to data
            test['data']['_token'] = csrf_token
            
            response = session.post(CREATE_CLASS_URL, data=test['data'], allow_redirects=False)
            
            if response.status_code == 422:  # Validation error
                print(f"    ✅ BLOCKED by validation (422)")
            elif response.status_code in [200, 201, 302]:
                print(f"    ⚠ ACCEPTED - Check if sanitized")
            else:
                print(f"    Status: {response.status_code}")
                
            results.append({
                'test': test['name'],
                'status': response.status_code,
                'blocked': response.status_code == 422
            })
        except Exception as e:
            print(f"    ❌ Error: {str(e)}")
    
    print("\n" + "-"*60)
    print("VALIDATION TEST SUMMARY:")
    blocked = sum(1 for r in results if r['blocked'])
    print(f"  Blocked by validation: {blocked}/{len(test_cases)}")
    if blocked >= 3:
        print("  ✅ INPUT VALIDATION IS WORKING!")
    else:
        print("  ⚠ WARNING: Some malicious inputs not blocked!")
    
    return results

# Main execution
if __name__ == "__main__":
    print("\n" + "="*60)
    print("KELASPINTU SECURITY TEST SUITE (CSRF-Enabled)")
    print("="*60)
    print(f"Target: {BASE_URL}")
    print(f"Started: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
    print("\nNote: This version properly handles CSRF tokens")
    
    # Check if BeautifulSoup is installed
    try:
        from bs4 import BeautifulSoup
    except ImportError:
        print("\n❌ ERROR: BeautifulSoup4 not installed!")
        print("Please run: pip install beautifulsoup4")
        exit(1)
    
    try:
        # Test 1: Registration Rate Limiting
        reg_results = test_registration_rate_limit()
        
        time.sleep(2)
        
        # Test 2: Class Creation Rate Limiting
        class_results = test_class_creation_rate_limit()
        
        time.sleep(2)
        
        # Test 3: Input Validation
        validation_results = test_input_validation()
        
        # Final Summary
        print("\n" + "="*60)
        print("FINAL SECURITY TEST REPORT")
        print("="*60)
        print(f"Completed: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
        print("\nSummary:")
        print("  1. Registration Rate Limiting: ", end="")
        if any(r.get('status') == 429 for r in reg_results):
            print("✅ WORKING")
        else:
            print("⚠ NOT DETECTED (may need more attempts)")
            
        print("  2. Class Creation Rate Limiting: ", end="")
        if any(r.get('status') == 429 for r in class_results):
            print("✅ WORKING")
        else:
            print("⚠ NOT DETECTED (may need more attempts)")
            
        print("  3. Input Validation: ", end="")
        if any(r.get('blocked') for r in validation_results):
            print("✅ WORKING")
        else:
            print("⚠ NOT DETECTED")
        
        print("\n" + "="*60)
        print("NOTE: This is a security test. All test data should be")
        print("      cleaned from production database after testing.")
        print("="*60)
        
    except KeyboardInterrupt:
        print("\n\n⚠ Test interrupted by user")
    except Exception as e:
        print(f"\n\n❌ Test suite error: {str(e)}")
        import traceback
        traceback.print_exc()
