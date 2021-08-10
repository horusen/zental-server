<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Created by Artisteer v4.3.0.60745 -->
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">

    <!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <link rel="stylesheet" href="{{ asset('style/mail-confirmation.css.css') }}" media="screen">




    <style>
        .open-content .open-postcontent-0 .layout-item-0 {
            padding-right: 10px;
            padding-left: 10px;
        }

        .open-content .open-postcontent-0 .layout-item-1 {
            color: #1F2833;
            background: #F6F7F8;
            background: rgba(246, 247, 248, 0.6);
        }

        .open-content .open-postcontent-0 .layout-item-2 {
            color: #1F2833;
            padding-right: 10px;
            padding-left: 10px;
        }

        .ie7 .open-post .open-layout-cell {
            border: none !important;
            padding: 0 !important;
        }

        .ie6 .open-post .open-layout-cell {
            border: none !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <div id="open-main">
        <div class="open-sheet clearfix">
            <header class="open-header">

                <div class="open-shapes">

                </div>

                <h1 class="open-headline">
                    <a href="/">Votre Compte pour Zentale</a>
                </h1>







            </header>
            <div class="open-layout-wrapper">
                <div class="open-content-layout">
                    <div class="open-content-layout-row">
                        <div class="open-layout-cell open-content">
                            <article class="open-post open-article">


                                <div class="open-postcontent open-postcontent-0 clearfix">
                                    <div class="open-content-layout">
                                        <div class="open-content-layout-row">
                                            <div class="open-layout-cell layout-item-0" style="width: 100%">
                                                <p class="MsoNormal"><span style="font-family: 'Comic Sans MS'; font-size: 16px; color: #145A80;">Bonjour {{ $receiver->nom_complet }},</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="open-content-layout layout-item-1">
                                        <div class="open-content-layout-row">
                                            <div class="open-layout-cell layout-item-2" style="width: 100%">
                                                <p class="MsoNormal"><span style="color: rgb(20, 90, 128); font-size: 14px;">Une inscription a été faite par {{ $sender->nom_complet }}, dans notre application «&nbsp;Zentale&nbsp;» en vous désignant comme proche.
                                                        Nous vous prions de bien vouloir cliquez sur le lien dessus pour confirmer.</span></p>

                                                <p class="MsoNormal"><span style="color: rgb(20, 90, 128); font-size: 14px;">&nbsp;Si le bouton
                                                        ci-dessus ne fonctionne pas, veuillez copier et coller l'URL ci-dessous dans un
                                                        nouvel onglet: </span></p>



                                                <p class="MsoNormal"><span style="font-size: 14px;"><span style="color: #145A80;">Ou si&nbsp;</span><b><span style="font-weight: normal; color: rgb(20, 90, 128);">{{ $receiver->email }}</span></b><span style="color: #145A80;">&nbsp;n'est
                                                            pas votre compte, veuillez ignorer cet e-mail.</span></span></p>



                                                <p class="MsoNormal"><span style="font-size: 14px;"><span style="color: #145A80;">Cordialement,</span><br style="text-align: start; box-sizing: border-box;">
                                                        <span style="text-align: start; color: #145A80;">L'équipe Open2sw</span></span></p>
                                                <p><span style="font-family: 'Comic Sans MS'; font-size: 16px;"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="open-content-layout">
                                        <div class="open-content-layout-row">
                                            <div class="open-layout-cell layout-item-0" style="width: 100%">
                                                <p style="text-align: center;"><br></p>
                                                <p style="text-align: center;"><a href="{{ $confirmation_link }}" target="blank" title="Cliquez ici pour valider votre inscription" class="open-button">Poursuivre l'inscription</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="open-footer">
                <p><a href="http://www.open2sw.com" target="_self" title="En savoir plus sur Open Software Solution In The World">Open2sw</a> | <a href="#">Nos Produits</a> | <a href="#">Contact</a></p>
                <p>Copyright © 2021. All Rights Reserved.</p>
            </footer>

        </div>
    </div>


</body>

</html>
