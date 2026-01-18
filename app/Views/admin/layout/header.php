<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?= esc($site_settings['company_name'] ?? 'Luxe & Co.') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        #wrapper {
            overflow-x: hidden;
            display: flex;
        }
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin .25s ease-out;
            width: 15rem;
            border-right: 1px solid #dee2e6;
        }
        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
            font-weight: bold;
        }
        #sidebar-wrapper .list-group {
            width: 15rem;
        }
        #page-content-wrapper {
            min-width: 100vw;
            flex: 1;
        }
        body.sb-sidenav-toggled #sidebar-wrapper {
            margin-left: 0;
        }
        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }
            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }
            body.sb-sidenav-toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
