<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Table</title>
</head>

<body>

    <table border="1">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kategori Layanan</th>
                <th colspan="2">Jenis Layanan</th>
                <th colspan="2">Checklist</th>
                <th colspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Ada</th>
                <th>Tidak Ada</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Data will be dynamically inserted here -->
        </tbody>
    </table>

    <script>
        // Sample data array
        const dataArray = [{
                kat_layanan: "Troubleshooting",
                jenis_layanan: "Aplikasi"
            },
            {
                kat_layanan: "Troubleshooting",
                jenis_layanan: "Jaringan"
            },
            {
                kat_layanan: "Instalasi",
                jenis_layanan: "Aplikasi"
            }
            // Add more data here if needed
        ];

        // Function to populate table based on data array
        function populateTable() {
            const tableBody = document.getElementById('tableBody');

            // Clear existing rows
            tableBody.innerHTML = '';

            // Iterate through data array and populate table
            dataArray.forEach((data, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td rowspan="2">${index + 1}</td>
                <td rowspan="2">${data.kat_layanan}</td>
                <td>1.${index + 1}</td>
                <td>${data.jenis_layanan}</td>
                <td><input type="checkbox"></td>
                <td><input type="checkbox"></td>
                <td></td>
                <td></td>
            `;
                tableBody.appendChild(row);
            });
        }

        // Call the function to initially populate the table
        populateTable();
    </script>

</body>

</html>