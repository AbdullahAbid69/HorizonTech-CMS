<!DOCTYPE html>
<html>

<head>
    <title>Student Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Container for the whole document */
        .container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Header Section */
        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Image */
        .image-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-section img {
            max-width: 100%;
            height: auto;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Highlighting Pass/Fail Status */
        .pass {
            color: green;
            font-weight: bold;
        }

        .fail {
            color: red;
            font-weight: bold;
        }

        .status {
            font-weight: normal;
        }

        /* Adding a responsive style for smaller screens */
        @media print {
            body {
                font-size: 10px;
            }

            table {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Image Section -->
        <div class="image-section">
            <img src="{{ asset('altImages/Horizon Tech (1).jpg') }}" alt="Horizon Tech Logo">
        </div>

        <!-- Header Title -->
        <h2>Student Results</h2>

        <!-- Table for Results -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course Title</th>
                    <th>Instructor</th>
                    <th>Sessional</th>
                    <th>Assignment</th>
                    <th>Mids</th>
                    <th>Final</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $index => $result)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $result->timetable->instructorCourseAssignment->course->title }}</td>
                        <td>{{ $result->timetable->instructorCourseAssignment->instructor->user->name ?? 'N/A' }}</td>
                        <td>{{ $result->sessionalMarks }}</td>
                        <td>{{ $result->assignmentMarks ?? '-' }}</td>
                        <td>{{ $result->midMarks }}</td>
                        <td>{{ $result->finalMarks }}</td>
                        <td>
                            @if($result->status === 'Pass')
                                <span class="pass">{{ $result->status }}</span>
                            @elseif($result->status === 'Fail')
                                <span class="fail">{{ $result->status }}</span>
                            @else
                                <span class="status">{{ $result->status ?? 'N/A' }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>