<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('welcomelayout.navbar_styleandhead')
        <!-- Add Province Rhamna content here -->
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
            <h1>Province Rhamna</h1>
        </header>

        <main class="container">
            <!-- Google Translate Widget -->
            <div class="google-translate">
                <div id="google_translate_element"></div>
            </div>
            <p>
                La Province de Rhamna, située dans la région de Marrakech-Safi au Maroc, est une zone étendue de 8 567 km², connue pour son agriculture prédominante. Le climat méditerranéen de la province, avec des étés chauds et secs et des hivers doux, influence fortement ses activités économiques. La région bénéficie de ressources hydriques importantes grâce au fleuve Oum Er-Rbia et plusieurs barrages, essentiels pour l'irrigation des cultures. En plus des céréales, des olives et des agrumes, l'élevage de chèvres et de moutons constitue également une part importante de l'économie locale.
                La province est reliée aux grandes villes comme Marrakech par des routes principales, facilitant ainsi les échanges commerciaux. Bien que le secteur touristique y soit en développement, il est encore limité comparé aux destinations plus populaires comme Marrakech. La province conserve néanmoins un riche patrimoine culturel berbère, avec des traditions vivantes, des festivals locaux et un artisanat traditionnel, incluant la poterie et les tapis berbères.
                Les services éducatifs et de santé sont présents mais peuvent être limités dans les zones rurales, obligeant les habitants à se déplacer vers des centres plus importants pour certains services. La vie communautaire est marquée par une forte solidarité et un sens de la tradition, avec des familles élargies et des associations locales jouant un rôle central dans le soutien et la cohésion sociale.
                Les défis auxquels la province est confrontée incluent la gestion durable de l'eau et l'amélioration des infrastructures et des services. Cependant, des projets de développement visent à moderniser l'agriculture, promouvoir l'agro-tourisme et améliorer les conditions de vie. Avec ses paysages diversifiés, allant des plaines agricoles aux collines et montagnes, Rhamna offre des opportunités pour les activités de plein air comme la randonnée, tout en préservant l’hospitalité et la culture traditionnelle de ses habitants.
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


