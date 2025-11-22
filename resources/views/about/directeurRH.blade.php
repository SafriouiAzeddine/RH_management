<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('welcomelayout.navbar_styleandhead')

        <!-- Add Directeur RH content here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding-top: 0;
            background: #f5f5f5;
            color: #333;
        }
        header {
            background: linear-gradient(135deg, #c2185b, #d32f2f);
            color: #fff;
            height: 250px; /* Set the desired height */
            padding: 0 20px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-bottom: 6px solid #fff;
            border-radius: 0 0 20px 20px;
            display: flex;
            align-items: center; /* Center content vertically */
            justify-content: center; /* Center content horizontally */
        }
        header h1 {
            margin: 0;
            font-size: 3em;
            color: #fff;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            line-height: 1.8;
            border-left: 5px solid #a32f6d;; /* Red left border */
        }
        .container p {
            margin-bottom: 20px;
            text-align: justify;
            color: #666;
        }
        .google-translate {
            margin-bottom: 20px;
            text-align: center;
        }
        @media (max-width: 768px) {
            header {
                padding: 20px 15px;
            }
            header h1 {
                font-size: 2em;
            }
            .container {
                width: 95%;
            }
        }
    </style>
</head>

<body>
    @include('welcomelayout.navbar')
    <header>
        <h1>Directeur RH</h1>
    </header>

    <main class="container">
        <!-- Google Translate Widget -->
        <div class="google-translate">
            <div id="google_translate_element"></div>
        </div>
        <p>
            Le Directeur Général est responsable de la direction stratégique de l'organisation. Il joue un rôle clé dans la définition des objectifs de l'entreprise, la gestion des opérations quotidiennes, et l'évaluation des performances globales. Le Directeur Général travaille en étroite collaboration avec les autres membres de la direction pour élaborer des plans de croissance, optimiser les ressources, et assurer l'alignement des opérations avec les objectifs stratégiques.
        </p>
        <p>
            Le rôle du Directeur Général inclut également la représentation de l'entreprise auprès des parties prenantes externes, telles que les investisseurs, les partenaires et les clients. Il veille à la bonne gestion des finances de l'entreprise, supervise les départements clés, et prend des décisions cruciales pour le succès et la pérennité de l'organisation.
        </p>
        <p>
            En matière de leadership, le Directeur Général doit inspirer et motiver les équipes, promouvoir une culture d'entreprise positive, et favoriser l'innovation et la créativité. Il est également responsable de la mise en œuvre des politiques internes, du respect des normes éthiques, et de la gestion des crises potentielles.
        </p>
        <p>
            Le Directeur Général travaille à l'amélioration continue des processus et des pratiques de l'entreprise, en se basant sur des analyses de performance et des feedbacks internes. Il est un acteur clé dans la définition et la mise en œuvre de la stratégie à long terme, visant à assurer la croissance durable et la compétitivité de l'organisation.
        </p>
    </main>

    <!-- Google Translate Script -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'fr',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
