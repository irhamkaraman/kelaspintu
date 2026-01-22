<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\LabSession;
use App\Models\Keanggotaan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 2 users
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $users = [$user1, $user2];

        // Class data templates
        $kelasData = [
            ['nama' => 'Pemrograman Web Dasar', 'deskripsi' => 'Belajar HTML, CSS, dan JavaScript dari dasar hingga mahir'],
            ['nama' => 'Database Management', 'deskripsi' => 'Menguasai SQL, normalisasi, dan optimasi database'],
            ['nama' => 'Python untuk Data Science', 'deskripsi' => 'Analisis data menggunakan Python, Pandas, dan NumPy'],
            ['nama' => 'Mobile App Development', 'deskripsi' => 'Membuat aplikasi mobile dengan React Native'],
            ['nama' => 'Machine Learning Fundamentals', 'deskripsi' => 'Dasar-dasar ML dengan scikit-learn dan TensorFlow'],
            ['nama' => 'Cloud Computing AWS', 'deskripsi' => 'Deploy aplikasi di Amazon Web Services'],
            ['nama' => 'Cybersecurity Basics', 'deskripsi' => 'Keamanan jaringan dan ethical hacking'],
            ['nama' => 'UI/UX Design', 'deskripsi' => 'Desain antarmuka yang user-friendly dengan Figma'],
            ['nama' => 'DevOps Engineering', 'deskripsi' => 'CI/CD, Docker, dan Kubernetes'],
            ['nama' => 'Blockchain Development', 'deskripsi' => 'Smart contracts dengan Solidity dan Ethereum'],
            ['nama' => 'Game Development Unity', 'deskripsi' => 'Membuat game 2D dan 3D dengan Unity Engine'],
            ['nama' => 'Laravel Framework', 'deskripsi' => 'Web development dengan Laravel PHP framework'],
            ['nama' => 'React.js Advanced', 'deskripsi' => 'State management, hooks, dan performance optimization'],
            ['nama' => 'Node.js Backend', 'deskripsi' => 'RESTful API dengan Express.js dan MongoDB'],
            ['nama' => 'Data Structures & Algorithms', 'deskripsi' => 'Struktur data dan algoritma untuk interview'],
            ['nama' => 'Computer Vision', 'deskripsi' => 'Image processing dengan OpenCV dan deep learning'],
            ['nama' => 'Natural Language Processing', 'deskripsi' => 'Text analysis dan chatbot development'],
            ['nama' => 'Internet of Things', 'deskripsi' => 'IoT dengan Arduino dan Raspberry Pi'],
            ['nama' => 'Artificial Intelligence', 'deskripsi' => 'AI concepts, neural networks, dan deep learning'],
            ['nama' => 'Software Testing', 'deskripsi' => 'Unit testing, integration testing, dan TDD'],
        ];

        // Create 20 classes
        foreach ($kelasData as $index => $data) {
            $creator = $users[$index % 2]; // Alternate between users
            
            $kelas = Kelas::create([
                'nama' => $data['nama'],
                'deskripsi' => $data['deskripsi'],
                'kode_unik' => strtoupper(substr(md5($data['nama'] . time() . $index), 0, 6)),
                'pembuat_id' => $creator->id,
            ]);

            // Add creator as instructor
            Keanggotaan::create([
                'kelas_id' => $kelas->id,
                'user_id' => $creator->id,
                'sebagai' => 'instruktur',
            ]);

            // Create 2-4 assignments per class
            $numTugas = rand(2, 4);
            for ($i = 1; $i <= $numTugas; $i++) {
                Tugas::create([
                    'kelas_id' => $kelas->id,
                    'judul' => "Tugas {$i}: " . $this->getTugasTitle($data['nama'], $i),
                    'deskripsi' => $this->getTugasDescription($data['nama'], $i),
                    'deadline' => '2026-01-10 23:59:59', // Fixed deadline: January 10, 2026
                ]);
            }

            // Create 1-3 lab sessions per class
            $numLabs = rand(1, 3);
            $languages = $this->getLanguageForClass($data['nama']);
            
            for ($i = 1; $i <= $numLabs; $i++) {
                LabSession::create([
                    'kelas_id' => $kelas->id,
                    'judul' => "Lab {$i}: " . $this->getLabTitle($data['nama'], $i),
                    'deskripsi' => $this->getLabDescription($data['nama'], $i),
                    'bahasa_pemrograman' => $languages[array_rand($languages)],
                    'template_code' => $this->getTemplateCode($data['nama']),
                    'test_cases' => json_encode([
                        [
                            'input' => 'test input 1',
                            'expected_output' => 'expected output 1',
                        ],
                        [
                            'input' => 'test input 2',
                            'expected_output' => 'expected output 2',
                        ],
                    ]),
                    'deadline' => '2026-01-10 23:59:59', // Fixed deadline: January 10, 2026
                ]);
            }
        }

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 User 1: budi@example.com (password: password123)');
        $this->command->info('📧 User 2: siti@example.com (password: password123)');
        $this->command->info('📚 Created 20 classes with assignments and labs');
    }

    private function getTugasTitle($kelasNama, $number)
    {
        $titles = [
            'Pemrograman Web Dasar' => ['Membuat Landing Page', 'Form Validation', 'Responsive Design', 'JavaScript DOM'],
            'Database Management' => ['ERD Design', 'Query Optimization', 'Stored Procedures', 'Database Normalization'],
            'Python untuk Data Science' => ['Data Cleaning', 'Exploratory Analysis', 'Visualization', 'Statistical Analysis'],
            'Mobile App Development' => ['UI Components', 'Navigation', 'API Integration', 'State Management'],
            'Machine Learning Fundamentals' => ['Linear Regression', 'Classification', 'Model Evaluation', 'Feature Engineering'],
        ];

        $default = ['Project ' . $number, 'Assignment ' . $number, 'Exercise ' . $number, 'Task ' . $number];
        return ($titles[$kelasNama] ?? $default)[$number - 1] ?? $default[$number - 1];
    }

    private function getTugasDescription($kelasNama, $number)
    {
        return "Kerjakan tugas {$number} untuk kelas {$kelasNama}. Ikuti instruksi dengan teliti dan kumpulkan sebelum deadline.";
    }

    private function getLabTitle($kelasNama, $number)
    {
        return "Praktikum {$number} - " . substr($kelasNama, 0, 30);
    }

    private function getLabDescription($kelasNama, $number)
    {
        return "Lab session {$number} untuk mempraktikkan materi {$kelasNama}. Selesaikan semua test cases untuk mendapatkan nilai penuh.";
    }

    private function getLanguageForClass($kelasNama)
    {
        $mapping = [
            'Pemrograman Web Dasar' => ['JavaScript'],
            'Database Management' => ['PHP'],
            'Python untuk Data Science' => ['Python'],
            'Mobile App Development' => ['JavaScript'],
            'Machine Learning Fundamentals' => ['Python'],
            'Cloud Computing AWS' => ['Python', 'JavaScript'],
            'Cybersecurity Basics' => ['Python'],
            'Laravel Framework' => ['PHP'],
            'React.js Advanced' => ['JavaScript'],
            'Node.js Backend' => ['JavaScript'],
            'Data Structures & Algorithms' => ['Python', 'Java'],
            'Computer Vision' => ['Python'],
            'Natural Language Processing' => ['Python'],
            'Internet of Things' => ['Python'],
            'Artificial Intelligence' => ['Python'],
            'Software Testing' => ['JavaScript', 'Python'],
        ];

        return $mapping[$kelasNama] ?? ['Python', 'JavaScript'];
    }

    private function getTemplateCode($kelasNama)
    {
        if (str_contains($kelasNama, 'Python') || str_contains($kelasNama, 'Machine Learning') || 
            str_contains($kelasNama, 'Data Science') || str_contains($kelasNama, 'AI')) {
            return "# TODO: Implement your solution here\n\ndef main():\n    pass\n\nif __name__ == '__main__':\n    main()";
        } elseif (str_contains($kelasNama, 'JavaScript') || str_contains($kelasNama, 'React') || 
                  str_contains($kelasNama, 'Node')) {
            return "// TODO: Implement your solution here\n\nfunction main() {\n    // Your code here\n}\n\nmain();";
        } elseif (str_contains($kelasNama, 'PHP') || str_contains($kelasNama, 'Laravel')) {
            return "<?php\n// TODO: Implement your solution here\n\nfunction main() {\n    // Your code here\n}\n\nmain();";
        } else {
            return "// TODO: Implement your solution here\n\nconsole.log('Hello World');";
        }
    }
}
