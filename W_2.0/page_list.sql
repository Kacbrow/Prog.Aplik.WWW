-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 06:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `matka` int(11) NOT NULL DEFAULT 0,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




-- --------------------------------------------------------

--
-- Table structure for table `page_list`
--

CREATE TABLE `page_list` (
  `id` int(1) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'glowna', '<!DOCTYPE html>\r\n<head>\r\n    \r\n    <link rel=\"stylesheet\" href=\"css/style.css\">\r\n    <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n    <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n    <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n    <title>Hodowla żółwia wodnego</title>\r\n   \r\n</head>\r\n<body>\r\n			<td colspan=\"3\">\r\n                <center>\r\n				\r\n                <h2>Witamy na naszej stronie!</h2>\r\n                <p> Na tej stronie są <b>informacje</b> o żółwiach wodnych. Jeśli będziesz miał jakieś pytania odnośnie żółwi wodnych zapraszam do zakładki Kontakt aby ze mną się skontaktować. 😊</p>\r\n                <br>\r\n				\r\n                <img  src=\"img/magicstudio-art.jpg\" alt=\"żółw\"  style=\"width:550px;height:550px\">\r\n				\r\n                </center>\r\n            </td>\r\n</body>', 1),
(2, 'Atlas', '<!DOCTYPE html>\r\n<head>\r\n    <link rel=\"stylesheet\" href=\"css/style.css\">\r\n    <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n    <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n    <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n    <title>Hodowla żółwia wodnego</title>\r\n\r\n    <style>\r\n            #atlas td, #atlas th {\r\n              border: 1px solid gray;\r\n              padding: 8px;\r\n              margin: 10px auto;\r\n              color: black;\r\n            }\r\n            #atlas { width: 100% }\r\n\r\n            #atlas tr:hover {background-color: lightgrey;}\r\n\r\n            #atlas th {\r\n              padding-top: 12px;\r\n              padding-bottom: 12px;\r\n              text-align: center;\r\n              background-color: blue;\r\n              color: white;\r\n            }\r\n    </style>\r\n</head>\r\n\r\n<body>\r\n    <table>\r\n        \r\n        <tr>\r\n            <td >\r\n                <h2>Spis Treści</h2>\r\n                        <ul>\r\n                            <li><a href=\"#zolw1\">Żółw błotny (Emys orbicularis)</a></li>\r\n                            <li><a href=\"#zolw2\">Żółw czerwonolicy (Trachemys scripta elegans) </a></li>\r\n                            <li><a href=\"#zolw3\">Żółw malowany (Chrysemys picta)</a></li>\r\n                            <li><a href=\"#zolw4\">Żółw chiński (Mauremys reevesii)</a></li>\r\n                            <li><a href=\"#zolw5\">Żółw żółtobrzuchy (Trachemys scripta scripta) </a></li>\r\n                         \r\n                        </ul>\r\n                        <h2 id=\"zolw1\">1. Żółw błotny (Emys orbicularis) - jest gatunkiem żółwia z rodziny żółwi błotnych (Emydidae) i podrzędu żółwi skrytoszyjnych. Jedyny gatunek żółwia żyjący naturalnie w Polsce, znany z  płaskiego, zaokrąglonego pancerza, ciemnozielonego lub brązowego ubarwienia oraz żółtych lub jasnych plamek na głowie i szyi. </h2>\r\n                        <img src=\"https://as2.ftcdn.net/v2/jpg/00/64/45/03/1000_F_64450383_Hknfc9h5i9rYWXQNOc3zUElw5eozoj2v.jpg\" alt=\"Zółw-błotny\" style=\"right:float;width:500px;height:400px;\">\r\n                        <br>\r\n                        <a href=\"https://stock.adobe.com/pl/contributor/202311203/nestonik?load_type=author&prev_url=detail\" target=\"_blank\">Author: nestonik</a>\r\n                        \r\n                        <p>\r\n                        <table id=\"atlas\">\r\n                        <tr>\r\n                            <th colspan=\"2\">Opis</th>\r\n                            <th>  </th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Występowanie</td>\r\n                            <td> Południowa i środkowa Europa, zachodnią Azję i północno-zachodnią Afrykę</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Biotop </td>\r\n                            <td> małe zbiorniki wodne takie jak małe jeziora, oczka wodne, bagna bądż stawy</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość</td>\r\n                            <td> ponad 17-20 cm (samice), do 18 cm (samce)</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Długość życia</td>\r\n                            <td> potrafi dożyć nawet do 120 lat</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Aktywność</td>\r\n                            <td>  od zakończenia snu zimowego (okres hibernacji trwa około 6 miesięcy od października do marca) </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Oświetlenie</td>\r\n                            <td> do 12h i UVB  </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Temperatura</td>\r\n                            <td> 22 - 28°C w wodzie</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wilgotność</td>\r\n                            <td> 50% - 70%</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Środowisko życia</td>\r\n                            <td> wodne\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Hodowla</td>\r\n                            <td> Jest gatunkiem chronionym o wysokim ryzyku wyginięcia. Jego hodowla jest dozwolona wyłącznie za specjalnym zezwoleniem Ministerstwa Środowiska i jedynie przez organizacje zajmujące się ochroną gatunku, reintrodukcją, edukacją lub badaniami. </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Rozmnażanie</td>\r\n                            <td> trudne</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Trudność w hodowli?</td>\r\n                            <td> zaawansowane </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Jak karmić?</td>\r\n                            <td> jest gatunkiem drapieżnym </td>\r\n                        </tr>\r\n                        </table>\r\n                        <h2 id=\"zolw2\">2. Żółw czerwonolicy (Trachemys scripta elegans)  - jest podgatunkiem żółwia ozdobnego (Trachemys scripta) z podrzędu żółwi skrytoszyjnych z rodziny żółwi błotnych (Emydidae). Pochodzący z Ameryki Północnej, znany z charakterystycznych czerwonych pasków na głowie i inwazyjności w wielu regionach świata.</h2>\r\n                        <img  src=\"https://as2.ftcdn.net/v2/jpg/03/54/16/59/1000_F_354165994_uIDB6owJmn2i46z11CfKb9EVcfIMX28H.jpg\" alt=\"Zółw-czerwonolicy\" style=\"right:float;width:500px;height:400px;\">\r\n                        <br>\r\n                        <a href=\"https://stock.adobe.com/pl/contributor/209622763/adam?load_type=author&prev_url=detail\" target=\"_blank\">Author: Adam</a>\r\n                        <p>\r\n                        <table id=\"atlas\">\r\n                        <tr>\r\n                            <th colspan=\"2\">Opis</th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Występowanie</td>\r\n                            <td> Naturalnie występuje w Ameryce Północnej a w takich krajach jak Europa, Azja i Australia jest gatunkiem inwazyjnym. Dlatego w wielu krajach wprowadzono dodatkowe przepisy, aby ograniczyć jego wpływ na naturalne środowisko.  </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Biotop </td>\r\n                            <td> Zbiorniki stojące takie jak staw, jezioro i bagna. </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość</td>\r\n                            <td> ponad 30 cm (samice), do 20 cm (samce)</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Długość życia</td>\r\n                            <td> między 20 a 40 lat</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Aktywność</td>\r\n                            <td> Dzień</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Oświetlenie</td>\r\n                            <td> 10-12h, UVB</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Temperatura</td>\r\n                            <td> 20-35°C</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wilgotność</td>\r\n                            <td> 50% - 70%</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość terrarium</td>\r\n                            <td> 80-100 litrów </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Środowisko życia</td>\r\n                            <td> wodne, naziemne\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Hodowla</td>\r\n                            <td> Może być pojedynczo trzymana, jeśli chcemy trzymać w większych grupach to trzeba pamiętać że za każdy dodatkowego żółwia musimy powiększać terrarium o około 50 litrów.\r\n                                W Polsce posiadanie żółwia czerwonolicego wymaga rejestracji w Wydziale Ochrony Środowiska lokalnego starostwa powiatowego w ciągu 14 dni od nabycia. Należy przedstawić dowód zakupu lub zaświadczenie od weterynarza potwierdzające, że żółw pochodzi z hodowli.</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Rozmnażanie</td>\r\n                            <td> Średnio trudne </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Trudność w hodowli?</td>\r\n                            <td> średni do zaawansowanego </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Jak karmić?</td>\r\n                            <td> możemy podawać rośliny takie jak estragon, koniczyna, chaber, czosnek pospolity, kolendra, majeranek, mak, lilak, bukszpan, fiołek, bazylia, cykoria, endywia, młoda pokrzywa, kolendra, lubczyk liście miliny/jeżyny, tymianek, słonecznik - cała roślina, trzykrotka i musimy uzupełniać ich dodatkowo dietę wodnymi owodami, ślimaki i rybami. </td>\r\n                        </tr>\r\n                        </table>\r\n                        <h2 id=\"zolw3\">3. Żółw malowany (Chrysemys picta)  -  jest gatunkiem gada z podrzędu żółwi skrytoszyjnych z rodziny żółwi błotnych (Emydidae). Jest to popularny gatunek słodkowodny, charakteryzujący się jasnymi, kontrastującymi wzorami na pancerzu i skórze, który występuje w różnych środowiskach wodnych w Ameryce Północnej.</h2>\r\n                        <img  src=\"https://as2.ftcdn.net/v2/jpg/06/68/53/35/1000_F_668533554_HSdupAaWuuJuG8GGbhMYoLyyB8NJUwNg.jpg\" alt=\"Zółw-malowany\" style=\"right:float;width:500px;height:400px;\">\r\n                        <br>\r\n                        <a href=\"https://stock.adobe.com/pl/contributor/204969557/bennytrapp?load_type=author&prev_url=detail\" target=\"_blank\">Author: bennytrapp</a>\r\n                        <p>\r\n                        <table id=\"atlas\">\r\n                        <tr>\r\n                            <th colspan=\"2\">Opis</th>\r\n                            <th> </th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Występowanie</td>\r\n                            <td> Od południowej Kanady aż do północnego Meksyku.  </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Biotop </td>\r\n                            <td> Zbiorniki takie jak staw, jezioro i bagna. </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość</td>\r\n                            <td> od 18 do 25 cm </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Długość życia</td>\r\n                            <td> między 20 a 40 lat</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Aktywność</td>\r\n                            <td> Dzień</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Oświetlenie</td>\r\n                            <td> 10-12h, UVB</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Temperatura</td>\r\n                            <td> 22-28°C w wodzie</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wilgotność</td>\r\n                            <td> 40% - 70%</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość terrarium</td>\r\n                            <td> 80-100 litrów </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Środowisko życia</td>\r\n                            <td> wodne\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Hodowla</td>\r\n                            <td> Może być pojedynczo trzymana, jeśli chcemy trzymać w większych grupach to trzeba pamiętać że za każdy dodatkowego żółwia musimy powiększać terrarium o około 50 litrów.\r\n                                Wwiezienie żółwia malowanego do Polski wymaga zgody Generalnego Dyrektora Ochrony Środowiska, a jego hodowla, rozmnażanie, sprzedaż i zbywanie wymagają zgody Regionalnego Dyrektora Ochrony Środowiska.</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Rozmnażanie</td>\r\n                            <td> Średnio trudne </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Trudność w hodowli?</td>\r\n                            <td> średni do zaawansowanego </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Jak karmić?</td>\r\n                            <td> Jest wszystkożernym gatunkiem więć możemy podawać rośliny i jak wodnymi owodami,  ryby małe, robaki. </td>\r\n                        </tr>\r\n                        </table>\r\n                        <h2 id=\"zolw4\">4. Żółw chiński (Mauremys reevesii) - znany także jako żółw chiński z trzema grzbietami lub żółw Reevesa, to popularny gatunek żółwia słodkowodnego występujący głównie w Azji.</h2>\r\n                        <img  src=\"https://vantisterra.pl/vt/sklep-internetowy/modules/amazzingblog/views/img/uploads/posts/171/1-668ea19fdc512.jpg\" alt=\"Zółw-malowany\" style=\"right:float;width:500px;height:400px;\">\r\n                        <br>\r\n                        <a href=\"https://vantisterra.pl/vt/portal-terrarystyczny/blog/gady/zolwie/zolw-chinski-mauremys-reevesii\" target=\"_blank\">Żródło zdjęcia </a>\r\n                        <p>\r\n                        <table id=\"atlas\">\r\n                        <tr>\r\n                            <th colspan=\"2\">Opis</th>\r\n                            <th> </th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Występowanie</td>\r\n                            <td> Azja wschodnia  </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Biotop </td>\r\n                            <td> Zbiorniki takie jak staw, jezioro i bagna. </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość</td>\r\n                            <td> 12 do 17 cm </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Długość życia</td>\r\n                            <td> między 25 a 30 lat</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Aktywność</td>\r\n                            <td> Dzień</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Oświetlenie</td>\r\n                            <td> 10-12h, UVB</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Temperatura</td>\r\n                            <td> 22-28°C </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wilgotność</td>\r\n                            <td> 50% - 70%</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość terrarium</td>\r\n                            <td> 80-100 litrów </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Środowisko życia</td>\r\n                            <td> wodne\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Hodowla</td>\r\n                            <td> Może być pojedynczo trzymana, jeśli chcemy trzymać w większych grupach to trzeba pamiętać że za każdy dodatkowego żółwia musimy powiększać terrarium o około 50 litrów.\r\n                                </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Rozmnażanie</td>\r\n                            <td> łatwe </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Trudność w hodowli?</td>\r\n                            <td> początkujący </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Jak karmić?</td>\r\n                            <td> Jest wszystkożernym gatunkiem więć możemy podawać rośliny i jak wodnymi owodami,  ryby małe, robaki. </td>\r\n                        </tr>\r\n                        </table>\r\n                        <h2 id=\"zolw5\">5. Żółw żółtobrzuchy (Trachemys scripta scripta) - jest podgatunkiem żółwia ozdobnego (Trachemys scripta) z podrzędu żółwi skrytoszyjnych z rodziny żółwi błotnych (Emydidae). Charakteryzujący się żółtą plamą za oczami oraz żółtym spodem pancerza. </h2>\r\n                        <br>\r\n                        <img  src=\"https://as2.ftcdn.net/v2/jpg/04/64/44/03/1000_F_464440359_KYlNT9S0pMdm63XHwteKQJToYUTWFc1q.jpg\" alt=\"Zółw-malowany\" style=\"right:float;width:500px;height:400px;\">\r\n                        <br>\r\n                        <a href=\"https://stock.adobe.com/pl/contributor/209599810/michael?load_type=author&prev_url=detail\" target=\"_blank\">Author: Michael </a>\r\n                        <p>\r\n                        <table id=\"atlas\">\r\n                        <tr>\r\n                            <th colspan=\"2\">Opis</th>\r\n                            <th> </th>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Występowanie</td>\r\n                            <td> południowo-wschodnie Stany Zjednoczone  </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Biotop </td>\r\n                            <td> stawy, jeziora i bagna </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość</td>\r\n                            <td> ponad 31 cm (samice), do 25 cm (samce)</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Długość życia</td>\r\n                            <td> między 20 a 30 lat</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Aktywność</td>\r\n                            <td> Dzień</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Oświetlenie</td>\r\n                            <td> 10-12h, UVB</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Temperatura</td>\r\n                            <td> 30-32°C </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wilgotność</td>\r\n                            <td> 50% - 70%</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Wielkość terrarium</td>\r\n                            <td> 80-100 litrów </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Środowisko życia</td>\r\n                            <td> wodne\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Hodowla</td>\r\n                            <td> Może być pojedynczo trzymana, jeśli chcemy trzymać w większych grupach to trzeba pamiętać że za każdy dodatkowego żółwia musimy powiększać terrarium o około 50 litrów.\r\n                                Wwiezienie żółwia malowanego do Polski wymaga zgody Generalnego Dyrektora Ochrony Środowiska, a jego hodowla, rozmnażanie, sprzedaż i zbywanie wymagają zgody Regionalnego Dyrektora Ochrony Środowiska.\r\n                                </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Rozmnażanie</td>\r\n                            <td> średnie </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Trudność w hodowli?</td>\r\n                            <td>  średniozaawansowanych </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td> Jak karmić?</td>\r\n                            <td> Jest wszystkożernym gatunkiem więć możemy podawać rośliny i jak wodnymi owodami,  ryby małe, robaki. </td>\r\n                        </tr>\r\n                        </table>\r\n\r\n                \r\n    </table>\r\n</body>\r\n                \r\n\r\n', 1),
(3, 'Sklepy', '<!DOCTYPE html>\r\n<head>\r\n   \r\n   <link rel=\"stylesheet\" href=\"css/style.css\">\r\n   <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n   <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n   <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n   <title>Hodowla żółwia wodnego</title>\r\n    \r\n    <style>\r\n        #strona td, #strona th {\r\n          border: 1px solid gray;\r\n          padding: 8px;\r\n          margin: 10px auto;\r\n          color: blue;\r\n        }\r\n        #strona {width: 18% }\r\n\r\n        #strona tr:hover {background-color: lightgrey;}\r\n\r\n        #strona th {\r\n          padding-top: 12px;\r\n          padding-bottom: 12px;\r\n          text-align: left;\r\n          background-color: green;\r\n          color: white;\r\n        }\r\n    </style>\r\n</head>\r\n<body>\r\n        <table id=\"strona\">\r\n		<center>\r\n		<h2> Oto kilku zaufanych hodowców żółwi w Polsce, którzy są znani z dobrej reputacji w branży </h2>\r\n		</center>\r\n            <tr>\r\n                <th>  strony internetowe hodowców</th>\r\n            </tr>\r\n            <tr>\r\n                <td> <a href=\"https://turtles.pl/kategoria-produktu/zwierzeta-gady-poznan/\" target=\"_blank\"> Hodowca z Poznania</a></td>\r\n            </tr>\r\n            <tr> \r\n                <td> <a href=\"https://e-bazyliszek.pl/37-zolwie\" target=\"_blank\"> Hodowca z Krakowa</a></td>\r\n            </tr>\r\n            <tr>\r\n                <td> <a href=\"https://vantisterra.pl/vt/portal-terrarystyczny/\" target=\"_blank\"> Hodowca z Krakowa</a></td>\r\n            </tr>\r\n        </center>\r\n        </table>\r\n		\r\n</body>', 1),
(4, 'Poradnik', '<!DOCTYPE html>\r\n<head>\r\n    \r\n    <link rel=\"stylesheet\" href=\"css/style.css\">\r\n    <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n    <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n    <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n    <title>Hodowla żółwia wodnego</title>\r\n    \r\n</head>\r\n<body>\r\n    <table>\r\n        \r\n        <tr>\r\n            <td>\r\n                <h2> Artykuły</h2>\r\n                <ol>\r\n                    <li><a href=\"html/Pierwsze.html\">Pierwsze terrarium</a></li>\r\n                </ol>\r\n                \r\n    </table>\r\n\r\n</body>\r\n', 1),
(5, 'Filmiki', '<!DOCTYPE html>\r\n<head>\r\n    <link rel=\"stylesheet\" href=\"css/style.css\">\r\n    <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n    <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n    <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n    <title>Hodowla żółwia wodnego</title>\r\n</head>\r\n<body>\r\n    \r\n	<td colspan=\"3\">\r\n		<center>\r\n		<h2>Tutaj są filmiki poradniki o żółwiach!</h2>\r\n		<h2>Miłego oglądania!</h2>\r\n		\r\n		<h2> 15 Best Aquatic Turtles (For Your Aquarium)</h2>\r\n		<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/6f0e1g0bxcs?si=amrd05SOnDeiU89k\" \r\n		title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; \r\n		encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe><br>\r\n		<h2>Co powinniśmy wiedzieć przed zakupem żółwia?</h2>\r\n		<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/RlPOGEXQ3Sk?si=Va1O1jiZrXfW0KWt\" \r\n		title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; \r\n		encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe><br>\r\n		</center>\r\n	\r\n\r\n	</td>\r\n\r\n\r\n</body>\r\n', 1),
(6, 'Kontakt', '<!DOCTYPE html>\r\n<head>\r\n   \r\n   <link rel=\"stylesheet\" href=\"css/style.css\">\r\n   <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n   <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n   <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n   <title>Hodowla żółwia wodnego</title>\r\n    \r\n</head>\r\n<body>\r\n    <table>\r\n        \r\n        <tr>\r\n            <td colspan=\"3\">\r\n                <h2>Skontaktuj się z nami</h2>\r\n                <form method=\"post\" action=\"mailto:169223@student.uwm.edu.pl\" >\r\n                <label for=\"name\">Imię:</label>\r\n                <input type=\"text\" id=\"name\" name=\"name\" required><br><br>\r\n                <label for=\"email\">Email:</label>\r\n                <input type=\"email\" id=\"email\" name=\"email\" required><br><br>\r\n                Wiadomość:<br>\r\n                <textarea name=\"message\" rows=\"8\" cols=\"30\"></textarea><br>\r\n                <input type=\"submit\" value=\"Wyślij\">\r\n                <input type=\"reset\" value=\"Wyczyść\">\r\n                </form>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</body>\r\n', 1),
(7, 'Galeria', '<!DOCTYPE html>\r\n<head>\r\n    \r\n    <link rel=\"stylesheet\" href=\"css/style.css\">\r\n    <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n    <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n    <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n    <title>Hodowla żółwia wodnego</title>\r\n   \r\n</head>\r\n<body>\r\n    \r\n</body>\r\n', 1),
(8, 'Lab3', '<!DOCTYPE html>\r\n<head>\r\n    \r\n    <link rel=\"stylesheet\" href=\"css/style.css\">\r\n	<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js\"></script>\r\n    <meta http-equiv=\"Content-type\" content=\"text/html\" charset=\"UTF-8\" >\r\n    <meta http-equiv=\"Content-Languege\" content=\"pl\" >\r\n    <meta name=\"Author\" content=\"Kacper Browarek\" >\r\n    <title>Hodowla żółwia wodnego</title>\r\n    \r\n    \r\n</head>\r\n<body>\r\n	<td colspan=\"3\">\r\n	<div id=\"zolw\" class=\"test-block\">Kliknij, a się powiększę</div>\r\n                <script>\r\n                    $(\"#zolw\").on(\"click\",function(){\r\n                        $(this).animate({\r\n                            width: \"500px\",\r\n                            opacity: 0.4,\r\n                            fontSize: \"3em\",\r\n                            borderwidth: \"10px\"\r\n                            \r\n                        },1500);\r\n                    });\r\n                </script>\r\n				\r\n                <div id=\"zolw1\" class=\"test-block\">Najedz, a się powiększe</div>\r\n                <script>\r\n                    $(\"#zolw1\").on({\r\n                        \"mouseover\" : function() {\r\n                            $(this).animate({\r\n                                width: 300\r\n                            }, 800);\r\n                        },\r\n                        \"mouseout\" : function() {\r\n                            $(this).animate({\r\n                                width: 200\r\n                            }, 800);\r\n                        }\r\n                    });\r\n                </script>\r\n\r\n                <div id=\"zolw2\" class=\"test-block\">Kliknij, abym urósł</div>\r\n                <script>\r\n                    $(\"#zolw2\").on(\"click\", function(){\r\n                        if(!$(this).is(\":animated\")){\r\n                            $(this).animate({\r\n                                width: \"+=\" + 50,\r\n                                height: \"+=\" + 10,\r\n                                opacity: \"0-\" + 0.1,\r\n                                duration : 3000\r\n                            });\r\n                        }\r\n                    });\r\n                </script>\r\n	</td>\r\n</body>\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `net_price` decimal(10,2) NOT NULL,
  `vat_tax` decimal(5,2) NOT NULL,
  `available_quantity` int(11) NOT NULL,
  `availability_status` enum('in_stock','out_of_stock','discontinued') NOT NULL,
  `category` int(11) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Indexes for dumped tables
--

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
