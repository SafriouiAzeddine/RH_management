<!-- resources/views/absences/gantt.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absence Schedule</title>
    <link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css">
    <style>
        #gantt_here {
            width: 100%;
            height: 600px;
        }
    </style>
</head>
<body>
    <div id="gantt_here"></div>

    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var absences = @json($absences);

            // Define the columns in the Gantt chart
            gantt.config.columns = [
                {name: "text", label: "Absence", tree: true, width: 250 },
                {name: "start_date", label: "Start Date", align: "center", width: 100 },
                {name: "end_date", label: "End Date", align: "center", width: 100 }
            ];

            // Initialize Gantt chart
            gantt.init("gantt_here");

            // Parse data into Gantt chart
            gantt.parse({
                data: absences.map(absence => ({
                    id: absence.id,
                    text: `Absence of ${absence.user.name}`,
                    start_date: absence.start_date,
                    end_date: absence.end_date,
                    type: 'project'
                }))
            });
        });
    </script>
</body>
</html>
