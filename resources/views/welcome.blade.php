<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('welcomelayout.welcome_head')
    </head>
    <body class="antialiased">
        @include('welcomelayout.navbar')
        <!--contentt here-->

        <main>
            @include('welcomelayout.maincontent')
        </main>

        

        <script>
            $(document).ready(function(){
                // Initialisation de Owl Carousel
                $('.owl-carousel').owlCarousel({
                    items: 1, // Nombre d'éléments visibles à la fois
                    loop: true, // Boucle infinie
                    margin: 0,
                    autoplay: true, // Autoplay
                    autoplayTimeout: 5000, // Temps entre chaque transition (en millisecondes)
                    smartSpeed: 800, // 0.8 seconds
                    onTranslate: function(event) {
                        // Masquer les overlays avant la transition
                        $('.overlay').removeClass('show');
                    },
                    onTranslated: function(event) {
                        // Ajouter un délai avant de montrer le texte
                        setTimeout(function() {
                            $('.owl-item.active .overlay').addClass('show');
                        }, 200); // Délai en millisecondes
                    }
                    });
                        // Assurez-vous que l'overlay du premier slide est visible au chargement initial
                    setTimeout(function() {
                        $('.owl-item.active .overlay').addClass('show');
                    }, 200); // Délai en millisecondes

    
                $('#ai-helper').on('click', function() {
                    $('#chatbox').toggle();
                });
    
                $('#close-chatbox').on('click', function() {
                    $('#chatbox').hide();
                });
    
                $('#send-btn').on('click', function() {
                    var userMessage = $('#chatbox-input').val();
                    if (userMessage.trim() !== '') {
                        $('#chatbox-body').append('<div class="user-message">' + userMessage + '</div>');
                        $('#chatbox-input').val('');
                        getAIResponse(userMessage);
                    }
                });
    
                function getAIResponse(message) {
                    $.ajax({
                        url: 'https://api.openai.com/v1/engines/davinci-codex/completions',
                        type: 'POST',
                        headers: {
                            'Authorization': 'Bearer YOUR_API_KEY_HERE',
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({
                            prompt: message,
                            max_tokens: 150
                        }),
                        success: function(response) {
                            var aiMessage = response.choices[0].text;
                            $('#chatbox-body').append('<div class="ai-message">' + aiMessage + '</div>');
                        },
                        error: function() {
                            $('#chatbox-body').append('<div class="ai-message">Erreur de réponse AI</div>');
                        }
                    });
                }
            });
        </script>


        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Owl Carousel JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

        
    </body>
</html>
