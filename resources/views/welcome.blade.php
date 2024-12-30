<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSA Transport Systems</title>
    <!-- Link to Google Fonts for Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="images/msa.png" type="image/png" sizes="512x512">
    <style>
        body {
            font-family: 'Roboto', sans-serif; /* Applied Roboto font */
            background: linear-gradient(135deg, rgb(1, 14, 67), rgb(3, 228, 248));
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        header {
            background: rgba(0, 0, 0, 0.5); /* Darkened the background for better contrast */
            padding: 30px 20px;
            text-align: center;
            position: relative;
            margin-bottom: 50px;
        }

        .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border-radius: 8px; /* Smooth edges */
        width: auto;
        height: auto;
        margin: 0 auto 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3); /* Soft shadow for depth */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo img {
            height: 80px;
            width: auto;
            transition: opacity 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05); /* Slight zoom on hover */
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.4); /* Slightly enhanced shadow */
        }

        .logo img:hover {
            opacity: 0.9; /* Subtle fade effect on hover */
        }

        header h1 {
            margin: 0;
            font-size: 3.5rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        header p {
            font-size: 1.25rem;
            margin-top: 10px;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
        }

        .feature {
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            border-radius: 10px;
            padding: 20px;
            width: 280px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.5);
            color: #fff;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.6);
        }

        .feature img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .cta {
            margin-top: 50px;
            text-align: center;
        }

        .cta a {
            text-decoration: none;
            color:rgb(26, 252, 237);
            background-color: rgba(0, 0, 0, 1);  /* Matching the gradient theme */
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1.1rem;
            margin: 10px;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .cta a:hover {
            background-color: rgba(0, 0, 0, 0.7);  /* A darker shade from the gradient for hover effect */
            transform: translateY(-5px);
        }

        footer {
            margin-top: 80px;
            font-size: 0.875rem;
            color: #fff;
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
        }

        @media (max-width: 768px) {
            .features {
                flex-direction: column;
                align-items: center;
            }

            .feature {
                width: 80%;
                margin-bottom: 20px;
            }

            .cta a {
                padding: 15px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ URL('images/msa.png') }}" alt="MSA Logo">
        </div>
        <h2>Welcome to</h2>
        <h1>MSA Transport Management System</h1>
        <p>Streamlining logistics with digital efficiency.</p>
    </header>

    <div class="container">
        <section class="features">
            <div class="feature">
                <img src="{{ URL('images/easy.png') }}" alt="Shipment Assignment">
                <h2>Easy Shipment Assignment</h2>
                <p>Assign shipments to drivers and vehicles effortlessly.</p>
            </div>
            <div class="feature">
                <img src="{{ URL('images/manual.png') }}" alt="Trip Tracking">
                <h2>Manual Trip Tracking</h2>
                <p>Track trips manually with precise updates.</p>
            </div>
            <div class="feature">
                <img src="{{ URL('images/comp.png') }}" alt="Reports">
                <h2>Comprehensive Reports</h2>
                <p>Generate detailed reports on transport activities.</p>
            </div>
        </section>

        <section class="cta">
            <a href="/login">Get Started</a>
        </section>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-3">MSA Transport Management System &copy; 2008 - {{ date('Y') }}. All rights reserved.</p>
        <p class="mb-0">
            <a href="https://www.msashipping.com/"
            class="text-decoration-none text-light p-2 fw-bold"
            style="transition: color 0.3s ease;"
            onmouseover="this.style.color='#007bff'"
            onmouseout="this.style.color='#f8f9fa'"
            onfocus="this.style.color='#007bff'"
            onblur="this.style.color='#f8f9fa'">
            <strong>WEB</strong></a> |

            <a href="tel:+94112385289"
            class="text-decoration-none text-light p-2 fw-bold"
            style="transition: color 0.3s ease;"
            onmouseover="this.style.color='#007bff'"
            onmouseout="this.style.color='#f8f9fa'"
            onfocus="this.style.color='#007bff'"
            onblur="this.style.color='#f8f9fa'">
            <strong>CONTACT</strong></a> |

            <a href="https://www.google.com/maps/place/MSA+Shipping+(Pvt)+Ltd/@6.9454448,79.8693685,16.89z/data=!4m6!3m5!1s0x3ae258ff59551eb7:0x7ea6baaec01a9b21!8m2!3d6.9454522!4d79.8746337!16s%2Fg%2F1ptwr_q_6?entry=ttu&g_ep=EgoyMDI0MTIxMS4wIKXMDSoASAFQAw%3D%3D"
            class="text-decoration-none text-light p-2 fw-bold"
            style="transition: color 0.3s ease;"
            onmouseover="this.style.color='#007bff'"
            onmouseout="this.style.color='#f8f9fa'"
            onfocus="this.style.color='#007bff'"
            onblur="this.style.color='#f8f9fa'">
            <strong>ADDRESS</strong></a>
        </p>
    </div>
</footer>

</body>
</html>
