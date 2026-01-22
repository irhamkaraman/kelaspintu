@extends('layouts.app')

@section('title', $lab->judul)

@section('content')
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('lab.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Lab List
        </a>
    </div>

    {{-- Dynamic Alert --}}
    <div id="dynamicAlert" class="hidden mb-6"></div>

    {{-- Main Container --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Code Editor (2 columns on desktop) --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Lab Info Card --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-4 sm:p-6 text-white shadow-xl">
                <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex-1 w-full">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            <h2 class="text-xl sm:text-2xl font-bold break-words">{{ $lab->judul }}</h2>
                        </div>
                        <p class="text-indigo-100 text-sm mb-3">{{ $lab->kelas->nama }}</p>

                        @if ($lab->deskripsi)
                            <p class="text-white/90 text-sm leading-relaxed mb-3 whitespace-pre-line">{{ $lab->deskripsi }}
                            </p>
                        @endif

                        @if ($lab->deadline)
                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Deadline: {{ $lab->deadline->format('d M Y, H:i') }}</span>
                                @if ($lab->sudahLewat())
                                    <span class="px-2 py-0.5 bg-red-500 rounded-full text-xs font-semibold">Terlewat</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex-shrink-0 w-full sm:w-auto">
                        <span
                            class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-xl text-sm font-bold uppercase tracking-wide w-full sm:w-auto text-center">
                            {{ $lab->bahasa_pemrograman }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Code Editor Card --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200">
                {{-- Editor Header --}}
                <div class="bg-slate-800 px-3 sm:px-4 py-3 flex items-center justify-between border-b border-slate-700">
                    <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                        <div class="flex gap-1.5 flex-shrink-0">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <span
                            class="text-slate-300 text-xs sm:text-sm font-medium truncate">code.{{ strtolower($lab->bahasa_pemrograman) }}</span>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs text-slate-400 whitespace-nowrap">Ctrl+Enter to run</span>
                    </div>
                </div>

                {{-- CodeMirror Editor --}}
                <div class="w-full overflow-hidden">
                    <div id="codeEditor" class="code-editor-container"></div>
                </div>

                {{-- Run Button --}}
                <div class="p-3 sm:p-4 bg-slate-50 border-t border-slate-200">
                    <button onclick="runCode()"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm sm:text-base"
                        id="runButton">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Run Code</span>
                        <span class="text-xs opacity-75 hidden sm:inline">(Ctrl+Enter)</span>
                    </button>
                </div>

                {{-- Instructor Actions --}}
                @if ($isInstruktur)
                    <div class="p-3 sm:p-4 bg-slate-100 border-t border-slate-200 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('lab.edit', $lab->id) }}" class="btn-outline text-sm flex-1 text-center">
                            Edit Lab
                        </a>
                        <a href="{{ route('lab.submissions', $lab->id) }}" class="btn-outline text-sm flex-1 text-center">
                            View Submissions
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right: Output & Results (1 column) --}}
        <div class="space-y-4">
            {{-- Terminal Output --}}
            <div class="bg-slate-900 rounded-2xl overflow-hidden shadow-xl border border-slate-700">
                <div class="bg-slate-800 px-3 sm:px-4 py-2 border-b border-slate-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-slate-300 text-xs sm:text-sm font-medium">Terminal</span>
                </div>
                <div class="p-3 sm:p-4">
                    <pre id="output"
                        class="text-green-400 font-mono text-xs sm:text-sm leading-relaxed min-h-[250px] sm:min-h-[300px] max-h-[400px] sm:max-h-[500px] overflow-auto terminal-scrollbar whitespace-pre-wrap break-words">$ Ready to execute code...
Press "Run Code" button to start.</pre>
                </div>
            </div>

            {{-- Test Results --}}
            <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-lg border border-slate-200">
                <h3 class="font-bold mb-4 flex items-center gap-2 text-slate-900 text-sm sm:text-base">
                    <svg class="w-5 h-5 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Test Results
                </h3>
                <div id="testResults" class="space-y-3 text-xs sm:text-sm"></div>
            </div>

            {{-- Last Submission --}}
            @if ($lastSubmission)
                <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-4 sm:p-6 border border-slate-200">
                    <h3 class="font-bold mb-3 text-slate-900 text-sm sm:text-base">Last Submission</h3>
                    <div class="space-y-2 text-xs sm:text-sm">
                        <div class="flex justify-between items-center gap-2">
                            <span class="text-slate-600">Status:</span>
                            <span
                                class="px-2 sm:px-3 py-1 rounded-full font-semibold text-xs
                        {{ $lastSubmission->status === 'passed'
                            ? 'bg-green-100 text-green-800'
                            : ($lastSubmission->status === 'failed'
                                ? 'bg-red-100 text-red-800'
                                : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($lastSubmission->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <span class="text-slate-600">Score:</span>
                            <span
                                class="text-xl sm:text-2xl font-bold text-indigo-600">{{ $lastSubmission->score }}/100</span>
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <span class="text-slate-600">Submitted:</span>
                            <span
                                class="text-slate-900 font-medium text-right">{{ $lastSubmission->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- CodeMirror CSS & JS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/dracula.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/clike/clike.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/python/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>

    <style>
        .code-editor-container {
            width: 100%;
            min-height: 400px;
        }

        .CodeMirror {
            height: 400px !important;
            width: 100% !important;
            font-size: 13px;
            line-height: 1.5;
            font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
        }

        @media (min-width: 640px) {
            .code-editor-container {
                min-height: 500px;
            }

            .CodeMirror {
                height: 500px !important;
                font-size: 14px;
                line-height: 1.6;
            }
        }

        .terminal-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .terminal-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 4px;
        }

        .terminal-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }

        .terminal-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Scrollbar for CodeMirror */
        .CodeMirror-scrollbar-filler,
        .CodeMirror-gutter-filler {
            background-color: #282a36;
        }

        .CodeMirror-vscrollbar::-webkit-scrollbar,
        .CodeMirror-hscrollbar::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        .CodeMirror-vscrollbar::-webkit-scrollbar-track,
        .CodeMirror-hscrollbar::-webkit-scrollbar-track {
            background: #282a36;
        }

        .CodeMirror-vscrollbar::-webkit-scrollbar-thumb,
        .CodeMirror-hscrollbar::-webkit-scrollbar-thumb {
            background: #44475a;
            border-radius: 5px;
        }

        .CodeMirror-vscrollbar::-webkit-scrollbar-thumb:hover,
        .CodeMirror-hscrollbar::-webkit-scrollbar-thumb:hover {
            background: #6272a4;
        }

        /* Fix line numbers width */
        .CodeMirror-linenumber {
            min-width: 30px !important;
            padding: 0 8px 0 5px !important;
        }

        .CodeMirror-gutters {
            min-width: 40px !important;
        }
    </style>

    <script>
        let editor;
        const language = "{{ $lab->bahasa_pemrograman }}";
        const testCases = @json($lab->test_cases ?? []);

        // Initialize CodeMirror
        document.addEventListener('DOMContentLoaded', function() {
            const initialCode = @json($lastSubmission->source_code ?? ($lab->template_code ?? ''));

            // Determine mode based on language
            let mode = 'text/x-java';
            if (language.toLowerCase() === 'python') mode = 'python';
            else if (language.toLowerCase() === 'javascript') mode = 'javascript';
            else if (language.toLowerCase() === 'php') mode = 'application/x-httpd-php';

            editor = CodeMirror(document.getElementById('codeEditor'), {
                value: initialCode,
                mode: mode,
                theme: 'dracula',
                lineNumbers: true,
                indentUnit: 4,
                tabSize: 4,
                indentWithTabs: false,
                lineWrapping: true,
                autoCloseBrackets: true,
                matchBrackets: true,
                viewportMargin: Infinity,
                extraKeys: {
                    "Ctrl-Enter": runCode,
                    "Cmd-Enter": runCode
                }
            });

            // Refresh editor on window resize
            window.addEventListener('resize', function() {
                editor.refresh();
            });
        });

        function showAlert(message, type = 'success') {
            const alertDiv = document.getElementById('dynamicAlert');
            const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
                type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
                'bg-blue-50 border-blue-200 text-blue-800';

            alertDiv.className = `${bgColor} p-4 rounded-lg border mb-6 flex items-start gap-3`;
            alertDiv.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <div class="flex-1">
            <p class="font-semibold text-sm sm:text-base">${message}</p>
        </div>
        <button onclick="this.parentElement.classList.add('hidden')" class="text-current opacity-50 hover:opacity-100 flex-shrink-0">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    `;

            setTimeout(() => alertDiv.classList.add('hidden'), 5000);
        }

        async function runCode() {
            const runButton = document.getElementById('runButton');
            const output = document.getElementById('output');
            const testResultsDiv = document.getElementById('testResults');
            const sourceCode = editor.getValue();

            if (!sourceCode.trim()) {
                showAlert('Please write some code first!', 'error');
                return;
            }

            runButton.disabled = true;
            runButton.innerHTML = `
        <svg class="animate-spin w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Executing...</span>
    `;

            output.textContent = '$ Executing code...\n';
            testResultsDiv.innerHTML = '';

            try {
                const response = await fetch("{{ route('lab.submit', $lab->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        source_code: sourceCode
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update output
                    let terminalOutput = `$ Code executed successfully!\n\n`;
                    terminalOutput += `=== OUTPUT ===\n${data.output || '(no output)'}\n\n`;

                    if (data.error) {
                        terminalOutput += `=== ERRORS ===\n${data.error}\n\n`;
                    }

                    terminalOutput += `=== RESULTS ===\n`;
                    terminalOutput += `Status: ${data.status.toUpperCase()}\n`;
                    terminalOutput += `Score: ${data.score}/100\n`;
                    terminalOutput += `Tests Passed: ${data.passed_tests}/${data.total_tests}\n`;

                    output.textContent = terminalOutput;

                    // Display test results
                    if (data.test_results && data.test_results.length > 0) {
                        testResultsDiv.innerHTML = data.test_results.map((result, index) => `
                    <div class="p-3 rounded-lg border ${result.passed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'}">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0 ${result.passed ? 'text-green-600' : 'text-red-600'}" fill="currentColor" viewBox="0 0 20 20">
                                ${result.passed ? 
                                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>' :
                                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
                                }
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium ${result.passed ? 'text-green-900' : 'text-red-900'} break-words">
                                    Test Case ${index + 1}: ${result.passed ? 'Passed' : 'Failed'}
                                </p>
                                ${!result.passed && result.error ? `<p class="text-xs mt-1 ${result.passed ? 'text-green-700' : 'text-red-700'} break-words">${result.error}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
                    } else {
                        testResultsDiv.innerHTML =
                            '<p class="text-slate-500 text-center py-4 text-xs sm:text-sm">No test cases defined</p>';
                    }

                    showAlert(`Code executed! Status: ${data.status} | Score: ${data.score}/100`, data.status ===
                        'passed' ? 'success' : 'error');
                } else {
                    output.textContent =
                        `$ Error executing code\n\n=== ERROR ===\n${data.message || 'Unknown error occurred'}`;
                    showAlert('Failed to execute code. Check terminal for details.', 'error');
                }
            } catch (error) {
                output.textContent = `$ Network Error\n\n${error.message}`;
                showAlert('Network error occurred. Please try again.', 'error');
            } finally {
                runButton.disabled = false;
                runButton.innerHTML = `
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
            </svg>
            <span>Run Code</span>
            <span class="text-xs opacity-75 hidden sm:inline">(Ctrl+Enter)</span>
        `;
            }
        }
    </script>
@endsection
