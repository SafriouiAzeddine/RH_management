<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('welcomelayout.navbar_styleandhead')

        <!-- Add Division RH content here -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding-top:0;
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
            border-left: 5px solid #a32f6d; /* Red left border */
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
        <h1>Direction des Ressources Humaines (DRH)</h1>
    </header>

    <main class="container">
        <!-- Google Translate Widget -->
        <div class="google-translate">
            <div id="google_translate_element"></div>
        </div>
        <p>
            La Direction des Ressources Humaines (DRH) est responsable de la gestion des ressources humaines au sein de notre organisation. Elle joue un rôle crucial dans le <span class="highlight">recrutement</span>, la gestion des <span class="highlight">talents</span>, et le développement des compétences.
        </p>
        <p>
            La division des Ressources Humaines (RH) est essentielle pour la gestion efficace du personnel au sein d'une organisation. Elle est responsable du <span class="highlight">recrutement</span> et de la sélection des candidats, en veillant à attirer les meilleurs talents pour répondre aux besoins de l'entreprise. La division assure également la <span class="highlight">formation</span> et le développement continu des employés pour améliorer leurs compétences et performances.
        </p>
        <p>
            Elle gère les <span class="highlight">évaluations de performance</span>, établit des objectifs pour les employés, et administre les <span class="highlight">salaires</span> ainsi que les <span class="highlight">avantages sociaux</span>, comme les assurances et les plans de retraite. Les relations avec les employés sont également au cœur des responsabilités de la division, avec la gestion des conflits et la promotion d'un environnement de travail positif.
        </p>
        <p>
            La conformité légale est une autre fonction clé, garantissant que l'organisation respecte toutes les lois du travail en vigueur. La division RH supervise les processus de départ des employés, que ce soit en cas de démission, de licenciement ou de retraite. L'analyse des données RH permet d’identifier les tendances et d’améliorer les pratiques en place.
        </p>
        <p>
            Elle est également impliquée dans la planification de la main-d'œuvre, anticipant les besoins futurs en personnel. La gestion de la <span class="highlight">santé et de la sécurité</span> au travail est primordiale pour assurer un environnement sûr pour tous les employés. La division facilite la communication interne, soutient les managers dans la gestion de leurs équipes et maintient les documents RH à jour.
        </p>
        <p>
            Elle joue un rôle dans le développement de la <span class="highlight">culture d'entreprise</span>, en promouvant les valeurs organisationnelles à travers divers programmes. Enfin, la division RH est en quête d'<span class="highlight">innovation</span> pour améliorer constamment les processus et les pratiques en place.
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

