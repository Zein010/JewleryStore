<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' | ' : '' ?><?= esc($site_settings['company_name'] ?? 'Luxe & Co.') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --gold: #bca374;
            --dark: #222;
            --light-gray: #f9f9f9;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
            background-color: #fff;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        /* --- Navbar --- */
        .navbar {
            padding: 1.5rem 0;
            background: white !important;
            border-bottom: 1px solid #eee;
            transition: 0.3s;
        }
        .nav-link {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 2px;
            font-weight: 500;
            margin: 0 15px;
            color: var(--dark) !important;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .navbar-brand img {
            max-height: 80px;
        }

        /* Footer */
        footer { border-top: 1px solid #eee; padding: 60px 0; background: #fff; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #777; text-decoration: none; font-size: 0.85rem; transition: 0.3s; }
        .footer-links a:hover { color: var(--gold); padding-left: 5px; }
        .footer-input { border: none; border-bottom: 1px solid #ddd; border-radius: 0; padding: 10px 0; font-size: 0.85rem; background: transparent !important; }
        .footer-input:focus { box-shadow: none; border-color: var(--gold); }
        .btn-subscribe { position: absolute; right: 0; top: 0; background: none; border: none; text-transform: uppercase; font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; height: 100%; color: var(--gold); padding: 0; }
        .fab { font-size: 1.1rem; transition: 0.3s; }
        .fab:hover { color: var(--gold); }
    </style>
</head>
<body>
