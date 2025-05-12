@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold mb-0">Academic Results</h3>
        <p class="text-muted mb-0">{{ \Carbon\Carbon::now()->format('F Y') }}</p>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <button id="downloadPdf" class="btn btn-primary">
                <i class="fas fa-file-pdf mr-2"></i> Download PDF
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="resultsTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="align-middle">#</th>
                                <th class="align-middle">Course Title</th>
                                <th class="align-middle text-center">Sessional</th>
                                <th class="align-middle text-center">Assignments</th>
                                <th class="align-middle text-center">Mids</th>
                                <th class="align-middle text-center">Final</th>
                                <th class="align-middle text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $index => $result)
                                <tr>
                                    <td class="align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle font-weight-bold">
                                        {{ $result->timetable->instructorCourseAssignment->course->title }}
                                        <small class="d-block text-muted">
                                            {{ $result->timetable->instructorCourseAssignment->course->code }}
                                        </small>
                                    </td>
                                    <td class="align-middle text-center">{{ $result->sessionalMarks ?? '-' }}</td>
                                    <td class="align-middle text-center">{{ $result->assignmentMarks ?? '-' }}</td>
                                    <td class="align-middle text-center">{{ $result->midMarks ?? '-' }}</td>
                                    <td class="align-middle text-center">{{ $result->finalMarks ?? '-' }}</td>
                                    <td class="align-middle text-center">
                                        @if($result->status === 'Pass')
                                            <span class="badge bg-success rounded-pill px-3 py-2 text-white">
                                                <i class="fas fa-check-circle mr-1"></i> {{ $result->status }}
                                            </span>
                                        @elseif($result->status === 'Fail')
                                            <span class="badge bg-danger rounded-pill px-3 py-2 text-white">
                                                <i class="fas fa-times-circle mr-1"></i> {{ $result->status }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                {{ $result->status ?? 'Pending' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No results available yet</h5>
                                            <p class="text-muted">Your results will appear here once published</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

    <script>
        // Initialize jsPDF
        const { jsPDF } = window.jspdf;

        $(document).ready(function () {
            // PDF Download Button Click Handler
            $('#downloadPdf').click(function (e) {
                e.preventDefault();
                generatePDF();
            });

            function generatePDF() {
                // Show loading state
                const btn = $('#downloadPdf');
                const originalHtml = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Generating PDF...');
                btn.prop('disabled', true);

                // Create new PDF document
                const doc = new jsPDF({
                    orientation: 'portrait',
                    unit: 'pt',
                    format: 'a4'
                });

                // Add title
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(18);
                doc.setTextColor(40, 40, 40);
                doc.text('ACADEMIC RESULTS', doc.internal.pageSize.getWidth() / 2, 40, { align: 'center' });

                // Add student info
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(12);
                doc.setTextColor(80, 80, 80);

                const studentInfo = [
                    `Student: {{ Auth::user()->name }}`,
                    `Program: {{ $program ?? 'N/A' }}`,
                    `Date: ${new Date().toLocaleDateString()}`
                ];

                doc.text(studentInfo, 40, 70);

                // Add institution logo or name
                doc.setFontSize(10);
                doc.setTextColor(150, 150, 150);
                doc.text('© {{ now()->year }} Your Institution Name', doc.internal.pageSize.getWidth() - 40, doc.internal.pageSize.height - 20, { align: 'right' });

                // Extract table data
                const headers = [];
                $('#resultsTable thead th').each(function () {
                    headers.push({
                        content: $(this).text().trim(),
                        styles: {
                            fillColor: [220, 220, 220],
                            textColor: [40, 40, 40],
                            fontStyle: 'bold',
                            cellPadding: 6
                        }
                    });
                });

                const data = [];
                $('#resultsTable tbody tr').each(function () {
                    const row = [];
                    $(this).find('td').each(function (index) {
                        // Special handling for status column
                        if (index === 6) {
                            const status = $(this).find('.badge').text().trim();
                            let fillColor;
                            if (status.includes('Pass')) {
                                fillColor = [40, 167, 69]; // green
                            } else if (status.includes('Fail')) {
                                fillColor = [220, 53, 69]; // red
                            } else {
                                fillColor = [108, 117, 125]; // gray
                            }

                            row.push({
                                content: status,
                                styles: {
                                    fillColor: fillColor,
                                    textColor: [255, 255, 255],
                                    fontStyle: 'bold',
                                    cellPadding: 4
                                }
                            });
                        } else {
                            row.push({
                                content: $(this).text().trim(),
                                styles: {
                                    cellPadding: 6,
                                    fontSize: 10,
                                    textColor: [40, 40, 40]
                                }
                            });
                        }
                    });
                    data.push(row);
                });

                // Create table
                doc.autoTable({
                    head: [headers],
                    body: data,
                    startY: 100,
                    margin: { left: 40, right: 40 },
                    styles: {
                        cellPadding: 6,
                        fontSize: 10,
                        valign: 'middle',
                        halign: 'center',
                        textColor: [40, 40, 40]
                    },
                    headStyles: {
                        fillColor: [240, 240, 240],
                        textColor: [40, 40, 40],
                        fontStyle: 'bold'
                    },
                    bodyStyles: {
                        fillColor: [255, 255, 255],
                        textColor: [40, 40, 40],
                        cellPadding: 6
                    },
                    alternateRowStyles: {
                        fillColor: [248, 249, 250]
                    },
                    columnStyles: {
                        0: { halign: 'center', cellWidth: 40 }, // #
                        1: { halign: 'left', cellWidth: 'auto' }, // Course Title
                        2: { cellWidth: 60 }, // Sessional
                        3: { cellWidth: 70 }, // Assignments
                        4: { cellWidth: 50 }, // Mids
                        5: { cellWidth: 50 }, // Final
                        6: { cellWidth: 70 }  // Status
                    },
                    didDrawPage: function (data) {
                        // Page footer
                        doc.setFontSize(10);
                        doc.setTextColor(150, 150, 150);
                        doc.text(`Page ${doc.internal.getNumberOfPages()}`,
                            doc.internal.pageSize.getWidth() / 2,
                            doc.internal.pageSize.height - 20,
                            { align: 'center' });
                    }
                });

                // Save the PDF
                setTimeout(() => {
                    doc.save('Academic_Results_{{ Auth::user()->name }}_{{ date("Y-m-d") }}.pdf');
                    btn.html(originalHtml);
                    btn.prop('disabled', false);
                }, 500);
            }
        });
    </script>

    <style>
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        #downloadPdf {
            transition: all 0.3s ease;
        }

        #downloadPdf:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection