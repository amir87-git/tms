<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSA Transport System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="icon" href="images/msa.png" type="image/png">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f9;
            color: #333;
            line-height: 1.6;
            margin: 0;
        }
        a {
            text-decoration: none;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #011043, #03e4f8);
            color: #fff;
            text-align: center;
            padding: 50px 20px; /* Reduced padding to reduce space */
            position: relative;
        }
        .hero .logo {
            margin-bottom: 15px; /* Reduced space between logo and title */
        }
        .hero h2 {
            margin: 10px 0; /* Reduced space above and below subheading */
            font-size: 1.8rem;
            font-family: 'Merriweather', serif;
            color: #fff;
        }
        .hero h1 {
            font-family: 'Roboto', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin: 10px 0; /* Reduced space between heading and subheading */
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px; /* Reduced space before button */
        }
        .hero .cta a {
            background-color: #fff;
            color: #011043;
            padding: 12px 25px; /* Adjusted padding for smaller button */
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .hero .cta a:hover {
            background-color: #03e4f8;
            color: #fff;
        }

        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 40px auto;
            max-width: 1200px;
            padding: 0 20px;
        }
        .feature {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }
        .feature img {
            max-width: 80px;
            margin-bottom: 15px;
        }
        .feature h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #011043;
        }
        .feature p {
            font-size: 1rem;
            color: #666;
        }

        /* Footer */
        footer {
            background: #011043;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }
        footer a {
            color: #03e4f8;
            margin: 0 5px;
            transition: color 0.3s ease;
        }
        footer a:hover {
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero {
                padding: 60px 20px;
            }
        }
        .logo {
            margin: 0 auto 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo img {
            height: 80px;
            width: auto;
            transition: opacity 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="hero-content">
            <div class="logo">
                <img src="{{ URL('images/msa.png') }}" alt="MSA Logo">
            </div>
            <h1>Transport Management System</h1>
        </div>
        <p>Streamlining logistics with digital efficiency.</p>
        <div class="cta">
            <a href="/login">Get Started</a>
        </div>
    </section>

    <section class="features">
        <div class="feature">
            <img src="{{ URL('images/easy.png') }}" alt="Easy Shipment Assignment">
            <h2>Easy Shipment Assignment</h2>
            <p>Assign shipments to drivers and vehicles effortlessly.</p>
        </div>
        <div class="feature">
            <img src="{{ URL('images/manual.png') }}" alt="Manual Trip Tracking">
            <h2>Manual Trip Tracking</h2>
            <p>Track trips manually with precise updates.</p>
        </div>
        <div class="feature">
            <img src="{{ URL('images/comp.png') }}" alt="Comprehensive Reports">
            <h2>Comprehensive Reports</h2>
            <p>Generate detailed reports on transport activities.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2008 - {{ date('Y') }} MSA Transport Management System. All rights reserved.</p>
        <p>
            <a href="https://www.msashipping.com/">WEB</a> |
            <a href="tel:+94112385289">CONTACT</a> |
            <a href="https://www.google.com/maps">ADDRESS</a>
        </p>
    </footer>
</body>
</html>
