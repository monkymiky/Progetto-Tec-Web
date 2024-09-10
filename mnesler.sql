-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Set 10, 2024 alle 12:12
-- Versione del server: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- Versione PHP: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mnesler`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Dati_cliente`
--

CREATE TABLE `Dati_cliente` (
  `Email` varchar(50) NOT NULL,
  `Cellulare` varchar(15) NOT NULL,
  `Indirizzo` varchar(50) DEFAULT NULL,
  `Nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Dati_cliente`
--

INSERT INTO `Dati_cliente` (`Email`, `Cellulare`, `Indirizzo`, `Nome`) VALUES
('abrahamcarney@google.it', '0726614333', '906-1505 Ac Rd.', 'Abraham Carney'),
('abuzzing25@nih.gov', '6078657537', '80 Hermina Pass', 'Alvin Buzzing'),
('aconkey2b@ycombinator.com', '7378420941', '7 Union Terrace', 'Anna-diane Conkey'),
('actonelliott2684@google.it', '0142933931', '2187 A St.', 'Acton Elliott'),
('aheineking29@webmd.com', '5725965487', '5 Amoth Center', 'Ax Heineking'),
('ahmedvalentine@google.it', '0923335339', '247-4364 A Av.', 'Ahmed Valentine'),
('aidanbauer@google.it', '0448386245', '485-2397 Erat Road', 'Aidan Bauer'),
('aileenelliott2157@google.it', '0660393450', '566-5478 Malesuada. St.', 'Aileen Elliott'),
('aleyl@wikipedia.org', '4814236286', '5 Mifflin Junction', 'Amitie Ley'),
('alicelong@google.it', '0335568555', 'P.O. Box 428, 9921 Libero. St.', 'Alice Long'),
('alyssarhodes6321@google.it', '0849498343', '9015 Nunc Rd.', 'Alyssa Rhodes'),
('amadge10@blogtalkradio.com', '2217126345', '570 Thierer Circle', 'Annis Madge'),
('aprilwilcox@google.it', '0643255886', 'Ap #550-6762 Netus St.', 'April Wilcox'),
('apullanx@omniture.com', '7696044530', '503 Superior Way', 'Augustin Pullan'),
('arayner1l@huffingtonpost.com', '9535148339', '89 Melby Lane', 'Adam Rayner'),
('ardenmoore638@google.it', '0593312983', 'P.O. Box 930, 2163 Ut Rd.', 'Arden Moore'),
('avavillarreal2342@google.it', '0855616635', 'Ap #541-9574 Mauris Av.', 'Ava Villarreal'),
('bbattyes@example.com', '3482620140', '57076 Corscot Street', 'Bobbie Battye'),
('bcornhill27@wisc.edu', '5246833924', '86 Shelley Plaza', 'Bayard cornhill'),
('beaufarrell@google.it', '0481836136', 'P.O. Box 511, 7143 Non Street', 'Beau Farrell'),
('bhayter2e@sakura.ne.jp', '3462708917', '428 Oneill Plaza', 'Bekki Hayter'),
('bhemeret28@hao123.com', '9827939832', '97818 Derek Avenue', 'Babb Hemeret'),
('bkernock1m@ustream.tv', '2336866104', '95741 Raven Terrace', 'Balduin Kernock'),
('blabla@car.it', '3485141945', 'Via Rinalda 39', 'JFK'),
('borismorales4566@google.it', '0568173414', 'P.O. Box 217, 8676 Tempus Ave', 'Boris Morales'),
('bradyowen@google.it', '0448108804', '6362 Morbi Avenue', 'Brady Owen'),
('brandonevans@google.it', '0002741741', '216-3600 Ornare. Rd.', 'Brandon Evans'),
('brennanyates@google.it', '0754844586', 'P.O. Box 102, 2133 Id, Street', 'Brennan Yates'),
('briannanorton9926@google.it', '0327898859', 'P.O. Box 914, 5669 Mattis St.', 'Brianna Norton'),
('briannawelch5126@google.it', '0384834663', '7340 Neque. Street', 'Brianna Welch'),
('bscafe1q@hc360.com', '6074328864', '2 Cardinal Avenue', 'Bibby Scafe'),
('bsilkstone@tuttocitta.it', '2105600133', '4 Declaration Trail', 'Blondell Silkston'),
('bworgen8@oracle.com', '2654593134', '89765 Moulton Parkway', 'Brynn Worgen'),
('caesarfloyd286@google.it', '0118341556', 'P.O. Box 368, 5075 Eu, Ave', 'Caesar Floyd'),
('cameronbyrd@google.it', '0776461833', '452-4401 Nec Av.', 'Cameron Byrd'),
('cburgwin16@about.com', '8194592568', '671 Sutherland Place', 'Chrisse Burgwin'),
('cdewicke2d@booking.com', '6241221828', '46428 Ohio Place', 'Cecilia Dewicke'),
('cdiz@phoca.cz', '6382400079', '66 Crest Line Hill', 'Cosette Di Maggio'),
('cgainsboroughi@devhub.com', '7989699153', '60 Shelley Way', 'Chaddie Gainsborough'),
('cgibb1z@reddit.com', '5018890043', '60189 Bultman Park', 'Cassy Gibb'),
('chantalestafford@google.it', '0545428126', 'P.O. Box 410, 8660 At Ave', 'Chantale Stafford'),
('charlesgood7559@google.it', '0653652411', 'Ap #965-6130 Ipsum Av.', 'Charles Good'),
('cjeffcoaty@ucoz.com', '2285829426', '5 Lunder Lane', 'Corrina Jeffcoat'),
('cjinda1b@howstuffworks.com', '1115257498', '73424 Burrows Pass', 'Carine Jinda'),
('cjoulr@wordpress.org', '9608733077', '946 Pine View Court', 'Charles Joul'),
('cladloe1r@purevolume.com', '4334149518', '833 Briar Crest Circle', 'Clemente Ladloe'),
('clintonraymond4575@google.it', '0664375141', '835-6127 Lectus Street', 'Clinton Raymond'),
('cobymerritt2116@google.it', '0576585305', '146-9529 Lorem, Av.', 'Coby Merritt'),
('cobyrivera@google.it', '0211384715', 'Ap #897-9465 Pede. Road', 'Coby Rivera'),
('colbyterrell5060@google.it', '0228838061', '386-6862 Lobortis. Road', 'Colby Terrell'),
('crontreem@admin.ch', '3341042426', '585 Dottie Point', 'Christin Rontree'),
('crosenauerh@cmu.edu', '4762933323', '292 Maple Pass', 'Cyrille Rosenauer'),
('cthomke1i@mashable.com', '8531049145', '021 Loftsgordon Pass', 'Cordie Thomke'),
('danekeith@google.it', '0243407034', 'Ap #473-8636 Enim St.', 'Dane Keith'),
('dcullenv@uiuc.edu', '6919963950', '158 Meadow Ridge Junction', 'Dame Cullen'),
('deirdrebrowning6945@google.it', '0036302360', '105-4661 Duis St.', 'Deirdre Browning'),
('dennisdaniels@google.it', '0942918186', 'Ap #993-3872 Lobortis Avenue', 'Dennis Daniels'),
('devinmoss@google.it', '0507284176', '6912 Accumsan Rd.', 'Devin Moss'),
('dflook1w@elpais.com', '4863352802', '03376 Hermina Crossing', 'Ddene Flook'),
('dknoles1y@marketwatch.com', '2022379474', '9 Washington Park', 'Darsey Knoles'),
('dloving1o@ebay.co.uk', '9061821705', '736 Heffernan Hill', 'Dorie Loving'),
('donnalandry812@google.it', '0196467493', '284-7065 Eget Street', 'Donna Landry'),
('dulyatt3@ucsd.edu', '7914725752', '7 Dovetail Road', 'Delmer Ulyatt'),
('ejonin5@dell.com', '6179241309', '2814 Spenser Court', 'Evelin Jonin'),
('elia@gmail.com', '3272453462', 'Via aaa bb 10', 'Elia Leonetti'),
('email@lol.ru', '1112223333', 'india', 'castello '),
('emarchington1v@examiner.com', '9251916719', '59737 Ridgeview Street', 'Elonore Marchington'),
('ericareynolds3752@google.it', '0126768552', 'P.O. Box 309, 8352 Sed Road', 'Erica Reynolds'),
('eripon15@xing.com', '4194384588', '45483 Dexter Street', 'Eldredge Ripon'),
('esnewin1n@yellowbook.com', '6345747011', '06 High Crossing Point', 'Eamon Snewin'),
('etommasi17@wufoo.com', '1122843108', '4082 Farmco Center', 'Eustace Tommasi'),
('ezrabenjamin@google.it', '0317726144', '2086 Sed, Avenue', 'Ezra Benjamin'),
('feliciamalone@google.it', '0908793452', '414-2797 Et, Road', 'Felicia Malone'),
('fionamercado354@google.it', '0107138322', '164-2975 Lorem, Av.', 'Fiona Mercado'),
('fkay1x@boston.com', '8357182998', '24375 Eliot Drive', 'Faydra Kay'),
('fscudder0@homestead.com', '5494291375', '7 Evergreen Point', 'Ferrel Scudder'),
('gadamssono@ning.com', '1464779804', '30 Everett Trail', 'Gloria Adamsson'),
('genevieveayers@google.it', '0552427298', 'Ap #264-9068 Vestibulum. Ave', 'Genevieve Ayers'),
('giselletorres5600@google.it', '0145918887', '845-9578 Montes, Road', 'Giselle Torres'),
('gkroona@imgur.com', '8146793165', '402 Jackson Place', 'Guendolen Kroon'),
('glennajackson@google.it', '0524451583', 'Ap #506-3560 Consequat Avenue', 'Glenna Jackson'),
('gmackintosh20@weather.com', '7278246107', '6061 Oneill Road', 'Gabriel MacKintosh'),
('gmecozzi2@weather.com', '4033478458', '1 Union Point', 'Gustavo Mecozzi'),
('gracemonroe5588@google.it', '0282144097', '571-6105 Nullam St.', 'Grace Monroe'),
('gregoryrice16@google.it', '0111585711', '729-2007 Vivamus Road', 'Gregory Rice'),
('hardinghardy4534@google.it', '0121658114', 'Ap #445-796 Gravida Ave', 'Harding Hardy'),
('hcasinep@mit.edu', '9438170014', '100 Norway Maple Center', 'Hanan Casine'),
('heidicampos9175@google.it', '0891131175', 'Ap #773-5241 Lectus. Street', 'Heidi Campos'),
('hgermon19@vk.com', '7182847352', '9955 Kenwood Road', 'Harley Germon'),
('hirokopierce@google.it', '0443809737', '881-6347 Morbi Ave', 'Hiroko Pierce'),
('holdershawd@joomla.org', '4076039320', '657 Duke Park', 'Howie Oldershaw'),
('hopcardenas1848@google.it', '0757501904', 'Ap #106-2288 Eleifend Rd.', 'Hop Cardenas'),
('iantrujillo@google.it', '0661845337', 'Ap #298-4403 Quisque Ave', 'Ian Trujillo'),
('ikedgeq@mit.edu', '9833343198', '3196 Longview Point', 'Inigo Kedge'),
('imaholland@google.it', '0257544484', 'Ap #659-6922 Morbi Road', 'Ima Holland'),
('ionagolden@google.it', '0851312429', '301-1662 Ultrices St.', 'Iona Golden'),
('irahardy@google.it', '0646345892', '412-5465 Sem Street', 'Ira Hardy'),
('iraweber@google.it', '0800576554', '394-6084 Eget Rd.', 'Ira Weber'),
('isabellekirkland@google.it', '0251532762', 'Ap #585-6474 Eros Av.', 'Isabelle Kirkland'),
('ishmaellawrence4918@google.it', '0556173264', '8651 Facilisis Rd.', 'Ishmael Lawrence'),
('jaymehurst5500@google.it', '0465766995', 'Ap #301-1570 Turpis. St.', 'Jayme Hurst'),
('jingarza7540@google.it', '0883089815', 'Ap #178-8142 In, Avenue', 'Jin Garza'),
('jliebermann1@answers.com', '3127103128', '76153 Mcbride Court', 'Joellen Liebermann'),
('jlindelof24@cyberchimps.com', '5596350467', '43 Swallow Place', 'Johnathon Lindelof'),
('joanlucas@google.it', '0667267387', '3724 Tincidunt Road', 'Joan Lucas'),
('joellerodgers@google.it', '0801755156', 'P.O. Box 571, 3865 Auctor Rd.', 'Joelle Rodgers'),
('josephschneider@google.it', '0582293554', 'P.O. Box 387, 6550 Mus. St.', 'Joseph Schneider'),
('jpallaschj@china.com.cn', '6246886012', '6 Mcbride Court', 'Jaquenetta Pallasch'),
('jshevell23@mit.edu', '5582206795', '0 Tony Avenue', 'Jerrold Shevell'),
('kabrahams1a@homestead.com', '5017908280', '72 Buell Center', 'Katalin Abrahams'),
('kanemclean7928@google.it', '0177167446', '832-8524 Aliquam Rd.', 'Kane Mclean'),
('karleighmontgomery@google.it', '0404178510', '6548 Ac Av.', 'Karleigh Montgomery'),
('karlyfry5446@google.it', '0660277457', '934-622 At, Road', 'Karly Fry'),
('kcotelard26@wsj.com', '8196153474', '74968 Veith Alley', 'Kellby Cotelard'),
('kfairley1t@indiegogo.com', '2791040028', '82273 High Crossing Parkway', 'Kelvin Fairley'),
('kiayadareeves@google.it', '0567143246', 'P.O. Box 782, 7810 Auctor, Street', 'Kiayada Reeves'),
('klochrank@quantcast.com', '8926877065', '583 Riverside Pass', 'Kevon Lochran'),
('kylefields6312@google.it', '0471916551', '5701 Mus. Rd.', 'Kyle Fields'),
('lacyhart@google.it', '0663838493', '375-3436 Felis Av.', 'Lacy Hart'),
('lcolbertson1s@cnn.com', '6941883114', '23068 Montana Circle', 'Langsdon Colbertson'),
('lhartwright13@seattletimes.com', '9693249149', '78150 Sutteridge Avenue', 'Lonna Hartwright'),
('ljenicekb@fc2.com', '6726460295', '31 Bobwhite Center', 'Lena Jenicek'),
('lmatzl1p@histats.com', '1185948947', '8 7th Parkway', 'Lynna Matzl'),
('luca.parise.3@lol.it', '2454171899', 'asdasdas', 'asdasd'),
('luca@hmao.ru', '1234154285', 'viaaaaaaaaaaaa', 'luca'),
('LucaParise0@gmail.com', '3455566545', 'iiiiiiiiiiiiiii', 'luca parise'),
('lucaparise100@gmail.com', '3476541999', 'via pollo', 'Luca Parise'),
('luneahester7351@google.it', '0604996775', '8867 Luctus. Rd.', 'Lunea Hester'),
('mackenzierocha@google.it', '0253926833', 'P.O. Box 786, 6025 Feugiat Ave', 'MacKenzie Rocha'),
('madalinebeach@google.it', '0474890256', 'P.O. Box 530, 5348 Suspendisse Avenue', 'Madaline Beach'),
('madonnaholden@google.it', '0224327317', 'Ap #107-2139 Enim Ave', 'Madonna Holden'),
('mageekey1340@google.it', '0044271247', '380-2679 Tincidunt, Ave', 'Magee Key'),
('malachicurry@google.it', '0156260181', 'P.O. Box 518, 2151 Risus Street', 'Malachi Curry'),
('matthewford9303@google.it', '0892544014', '1945 Placerat Rd.', 'Matthew Ford'),
('mcahen7@adobe.com', '7603912223', '468 Chinook Place', 'Merola Cahen'),
('mdixon1d@odnoklassniki.ru', '3961478915', '101 Erie Place', 'Marta Dixon'),
('merrillhaynes@google.it', '0256552124', 'Ap #486-1458 Risus. Road', 'Merrill Haynes'),
('mharriskine1h@europa.eu', '5799978009', '499 Judy Plaza', 'Miran Harriskine'),
('michines2001@gmail.com', '3776639323', 'Via druso 92', 'Michele Nesler'),
('michines@gmail.com', '1116639331', 'Via druso 1111', 'Michele'),
('miriammoses1647@google.it', '0579254136', '770-4320 In St.', 'Miriam Moses'),
('mmilne1j@adobe.com', '5277527180', '6814 Lotheville Pass', 'Mable Milne'),
('mstalman22@symantec.com', '8378698231', '31561 Barby Parkway', 'Miguela Stalman'),
('msweating2a@xinhuanet.com', '3011901525', '059 Barnett Park', 'Maximo Sweating'),
('mtritten1c@cnbc.com', '8782072633', '07 Manufacturers Plaza', 'Merell Tritten'),
('mvannozzii1u@rediff.com', '6083476480', '50 Artisan Parkway', 'Maude Vannozzii'),
('nadineknowles@google.it', '0775506707', '9216 Tristique Ave', 'Nadine Knowles'),
('nbygrove1e@ox.ac.uk', '7365783566', '093 Manitowish Place', 'Nickie Bygrove'),
('nereahammond@google.it', '0766699732', 'Ap #548-4844 Posuere Rd.', 'Nerea Hammond'),
('ngrabeham2c@chronoengine.com', '9944508553', '2803 Graedel Parkway', 'Nicky Grabeham'),
('nigelchurch@google.it', '0187779767', 'Ap #874-1547 Libero. St.', 'Nigel Church'),
('normanwhitley8055@google.it', '0765263408', 'Ap #186-1781 Nec Road', 'Norman Whitley'),
('orlandocarrillo@google.it', '0353123641', '352-6822 Feugiat. St.', 'Orlando Carrillo'),
('orlandostokes@google.it', '0287724211', '5795 Dolor. Rd.', 'Orlando Stokes'),
('orsonwilliamson8999@google.it', '0625683930', 'Ap #884-4560 Sem. Av.', 'Orson Williamson'),
('pblazynski9@odnoklassniki.ru', '6721579908', '3803 Wayridge Center', 'Pascale Blazynski'),
('pcornforth1k@seattletimes.com', '5627931562', '55 Trailsway Crossing', 'Philipa Cornforth'),
('pfears11@weibo.com', '6901391339', '296 Grasskamp Place', 'Pascale Fears'),
('pfilisov1g@bloglines.com', '6679206225', '96515 Pepper Wood Lane', 'Peggie Filisov'),
('rajabowers@google.it', '0518978454', '615-9022 At Road', 'Raja Bowers'),
('raphaeldyer6810@google.it', '0850480639', 'Ap #501-9500 Risus Street', 'Raphael Dyer'),
('raxelbeeg@printfriendly.com', '5327055809', '833 Nevada Lane', 'Rosamund Axelbee'),
('rbrankleyf@zimbio.com', '9378631435', '805 Lindbergh Alley', 'Roberta Brankley'),
('rcarss12@columbia.edu', '9833982496', '63 Prairieview Lane', 'Reagen Carss'),
('rchivrall14@youku.com', '7104137956', '051 Swallow Pass', 'Rosana Chivrall'),
('remediosknapp702@google.it', '0666872285', 'Ap #278-1152 Libero Rd.', 'Remedios Knapp'),
('rjanoschekc@whitehouse.gov', '4861207381', '09 Eggendart Street', 'Rea Janoschek'),
('ryleeedwards8792@google.it', '0402024812', '752-1785 Sed, Street', 'Rylee Edwards'),
('sadeclements1843@google.it', '0354142184', 'Ap #648-1457 Mauris Road', 'Sade Clements'),
('sbercher6@ihg.com', '8354226972', '28 Village Alley', 'Sharai Bercher'),
('sbrett4@va.gov', '5376590840', '70 Talisman Junction', 'Steward Brett'),
('seancabrera@google.it', '0079597357', 'Ap #961-4184 Suspendisse Rd.', 'Sean Cabrera'),
('sebastianwebster@google.it', '0165427575', '4750 Vel Rd.', 'Sebastian Webster'),
('senticottn@plala.or.jp', '1961429449', '90262 Fieldstone Junction', 'Scarlett Enticott'),
('sierramyers@google.it', '0732605205', 'Ap #368-3218 Mauris Rd.', 'Sierra Myers'),
('silasduncan7185@google.it', '0254383113', 'Ap #641-8495 In Ave', 'Silas Duncan'),
('sopolinebarrera@google.it', '0271302875', '728-636 Velit Rd.', 'Sopoline Barrera'),
('svealt@chicagotribune.com', '7677026018', '7 Ramsey Avenue', 'Sol Veal'),
('sworstall18@sphinn.com', '8613233366', '7 Ludington Junction', 'Sybyl Worstall'),
('tallulahmarsh5656@google.it', '0337088096', '491-3556 Sem. Avenue', 'Tallulah Marsh'),
('tanekwitt@google.it', '0738026005', 'Ap #756-1000 Dictum Rd.', 'Tanek Witt'),
('thomasmacias@google.it', '0484228832', '4635 Risus. Av.', 'Thomas Macias'),
('tigerrodgers4819@google.it', '0051192390', '536-5132 Dolor. St.', 'Tiger Rodgers'),
('toddhudson@google.it', '0933874247', 'Ap #368-3464 Libero Rd.', 'Todd Hudson'),
('tofu@ramen.jp', '1234154285', 'osaka nigiri street', 'tofu'),
('ttokell1f@marriott.com', '7501379441', '7 Elka Lane', 'Tommie Tokell'),
('twindersw@pcworld.com', '9646779392', '7148 Fairfield Pass', 'Thalia Winders'),
('vielkaclemons2218@google.it', '0085488521', 'Ap #206-9505 Mauris, Rd.', 'Vielka Clemons'),
('vladimirfitzpatrick366@google.it', '0447044478', 'Ap #665-5104 Donec Ave', 'Vladimir Fitzpatrick'),
('wfarriaru@irs.gov', '4128703637', '33 Spaight Drive', 'Werner Farriar'),
('whoopivalencia@google.it', '0139822479', '413-4431 Metus Rd.', 'Whoopi Valencia'),
('wynterberg9705@google.it', '0017561118', '816-8827 Molestie St.', 'Wynter Berg'),
('xanthagentry@google.it', '0363725151', 'P.O. Box 182, 1845 Nunc Road', 'Xantha Gentry'),
('xanthahicks8321@google.it', '0129571394', '970-6944 Gravida Street', 'Xantha Hicks'),
('xavierabeach6024@google.it', '0421627827', 'Ap #341-370 Lectus. St.', 'Xaviera Beach'),
('ypetruska21@google.ca', '2175767144', '53239 Golf Course Avenue', 'Yvor Petruska'),
('zacheryavila2914@google.it', '0786134787', '810-5149 Curabitur Ave', 'Zachery Avila'),
('zkettlesing2g@yandex.ru', '6413946564', '0 Derek Point', 'Zonnya Kettlesing');

-- --------------------------------------------------------

--
-- Struttura della tabella `Login`
--

CREATE TABLE `Login` (
  `Username` varchar(20) NOT NULL,
  `Pass` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Login`
--

INSERT INTO `Login` (`Username`, `Pass`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Struttura della tabella `NonDisponibili`
--

CREATE TABLE `NonDisponibili` (
  `Data_Ora_Inizio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `NonDisponibili`
--

INSERT INTO `NonDisponibili` (`Data_Ora_Inizio`) VALUES
('2024-07-01 08:30:00'),
('2024-07-01 10:00:00'),
('2024-07-01 16:00:00'),
('2024-07-02 08:30:00'),
('2024-07-02 13:00:00'),
('2024-07-03 10:00:00'),
('2024-07-03 14:30:00'),
('2024-07-03 16:00:00'),
('2024-07-04 10:00:00'),
('2024-07-04 14:30:00'),
('2024-07-05 08:30:00'),
('2024-07-05 10:00:00'),
('2024-07-05 19:00:00'),
('2024-07-06 13:00:00'),
('2024-07-07 11:30:00'),
('2024-07-07 17:30:00'),
('2024-07-09 10:00:00'),
('2024-07-09 14:30:00'),
('2024-09-04 11:30:00'),
('2024-09-05 08:30:00'),
('2024-09-05 10:00:00'),
('2024-09-05 11:30:00'),
('2024-09-05 13:00:00'),
('2024-09-05 14:30:00'),
('2024-09-05 17:30:00'),
('2024-09-05 19:00:00'),
('2024-09-05 20:30:00'),
('2024-09-06 14:30:00'),
('2024-09-06 16:00:00'),
('2024-09-07 08:30:00'),
('2024-09-07 10:00:00'),
('2024-09-07 16:00:00'),
('2024-09-08 08:30:00'),
('2024-09-08 10:00:00'),
('2024-09-08 11:30:00'),
('2024-09-08 13:00:00'),
('2024-09-10 08:30:00'),
('2024-09-10 13:00:00'),
('2024-09-11 11:30:00'),
('2024-09-11 16:00:00'),
('2024-09-11 17:30:00'),
('2024-09-11 19:00:00'),
('2024-09-12 08:30:00'),
('2024-09-12 10:00:00'),
('2024-09-12 11:30:00'),
('2024-09-12 13:00:00'),
('2024-09-12 17:30:00'),
('2024-09-13 08:30:00'),
('2024-09-13 10:00:00'),
('2024-09-13 14:30:00'),
('2024-09-13 16:00:00'),
('2024-09-13 20:30:00'),
('2024-09-14 14:30:00'),
('2024-09-18 11:30:00'),
('2024-09-18 20:30:00'),
('2024-09-19 11:30:00'),
('2024-09-19 13:00:00'),
('2024-09-26 11:30:00'),
('2024-09-26 13:00:00'),
('2024-09-27 14:30:00'),
('2024-09-27 16:00:00'),
('2024-09-29 14:30:00'),
('2024-09-29 16:00:00'),
('2024-09-30 08:30:00'),
('2024-09-30 10:00:00'),
('2024-09-30 11:30:00'),
('2024-09-30 13:00:00'),
('2024-09-30 17:30:00'),
('2024-10-01 14:30:00'),
('2024-10-01 16:00:00'),
('2024-10-03 14:30:00'),
('2024-10-03 16:00:00'),
('2024-10-07 11:30:00'),
('2024-10-16 14:30:00'),
('2024-10-17 14:30:00'),
('2024-11-30 08:30:00'),
('2024-11-30 10:00:00'),
('2024-11-30 13:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `Prenotazioni`
--

CREATE TABLE `Prenotazioni` (
  `Data_Ora_Inizio` datetime NOT NULL,
  `Tipo` tinyint(1) NOT NULL,
  `InfoAggiuntive` varchar(500) DEFAULT NULL,
  `Cliente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Prenotazioni`
--

INSERT INTO `Prenotazioni` (`Data_Ora_Inizio`, `Tipo`, `InfoAggiuntive`, `Cliente`) VALUES
('2024-07-01 16:00:00', 1, 'SomeInfo', 'mageekey1340@google.it'),
('2024-07-02 08:30:00', 1, 'SomeInfo', 'zacheryavila2914@google.it'),
('2024-07-03 10:00:00', 0, 'SomeInfo', 'whoopivalencia@google.it'),
('2024-07-04 14:30:00', 1, 'SomeInfo', 'orsonwilliamson8999@google.it'),
('2024-07-05 19:00:00', 1, 'SomeInfo', 'dennisdaniels@google.it'),
('2024-07-07 11:30:00', 0, 'SomeInfo', 'bradyowen@google.it'),
('2024-07-07 17:30:00', 1, 'SomeInfo', 'bradyowen@google.it'),
('2024-07-09 10:00:00', 1, 'SomeInfo', 'dennisdaniels@google.it'),
('2024-09-04 10:00:00', 0, '', 'michines@gmail.com'),
('2024-09-04 11:30:00', 0, 'prova modifica', 'michines@gmail.com'),
('2024-09-04 16:00:00', 0, 'prova finale!', 'michines@gmail.com'),
('2024-09-05 08:30:00', 0, '', 'michines@gmail.com'),
('2024-09-05 10:00:00', 1, '', 'michines@gmail.com'),
('2024-09-05 11:30:00', 1, 'prova a domicilio', 'michines@gmail.com'),
('2024-09-05 14:30:00', 1, '', 'michines@gmail.com'),
('2024-09-05 17:30:00', 1, '', 'michines@gmail.com'),
('2024-09-05 20:30:00', 0, '', 'michines@gmail.com'),
('2024-09-06 14:30:00', 1, '', 'michines@gmail.com'),
('2024-09-07 08:30:00', 1, '', 'michines@gmail.com'),
('2024-09-07 14:30:00', 1, '', 'michines@gmail.com'),
('2024-09-08 08:30:00', 1, '', 'michines@gmail.com'),
('2024-09-08 11:30:00', 1, 'Note aggiuntive', 'elia@gmail.com'),
('2024-09-10 08:30:00', 0, '', 'michines2001@gmail.com'),
('2024-09-10 13:00:00', 0, '', 'michines2001@gmail.com'),
('2024-09-11 11:30:00', 0, '', 'michines2001@gmail.com'),
('2024-09-11 16:00:00', 0, '', 'luca@hmao.ru'),
('2024-09-11 17:30:00', 1, 'a domicilio', 'michines2001@gmail.com'),
('2024-09-12 08:30:00', 1, '', 'michines@gmail.com'),
('2024-09-12 11:30:00', 1, '', 'michines@gmail.com'),
('2024-09-12 17:30:00', 0, '', 'luca.parise.3@lol.it'),
('2024-09-13 08:30:00', 1, 'in deutsch', 'michines2001@gmail.com'),
('2024-09-13 14:30:00', 1, '', 'michines2001@gmail.com'),
('2024-09-13 20:30:00', 0, '', 'lucaparise100@gmail.com'),
('2024-09-14 14:30:00', 0, '', 'michines2001@gmail.com'),
('2024-09-18 11:30:00', 0, '', 'blabla@car.it'),
('2024-09-18 20:30:00', 0, 'inps', 'email@lol.ru'),
('2024-09-19 11:30:00', 1, '', 'luca@hmao.ru'),
('2024-09-26 11:30:00', 1, '', 'luca@hmao.ru'),
('2024-09-27 14:30:00', 1, '', 'tofu@ramen.jp'),
('2024-09-29 14:30:00', 1, '', 'luca@hmao.ru'),
('2024-09-30 08:30:00', 1, '', 'lucaparise100@gmail.com'),
('2024-09-30 11:30:00', 0, '', 'lucaparise100@gmail.com'),
('2024-09-30 13:00:00', 0, '', 'lucaparise100@gmail.com'),
('2024-09-30 17:30:00', 0, '', 'lucaparise100@gmail.com'),
('2024-10-01 14:30:00', 1, '', 'tofu@ramen.jp'),
('2024-10-02 20:30:00', 0, 'prova', 'michines@gmail.com'),
('2024-10-03 14:30:00', 1, '', 'luca@hmao.ru'),
('2024-10-07 11:30:00', 0, '', 'LucaParise100@gmail.com'),
('2024-10-16 14:30:00', 0, '', 'tofu@ramen.jp'),
('2024-10-17 14:30:00', 0, 'aaaa', 'LucaParise0@gmail.com'),
('2024-11-30 08:30:00', 1, '', 'lucaparise100@gmail.com'),
('2024-11-30 13:00:00', 0, '', 'lucaparise100@gmail.com');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Dati_cliente`
--
ALTER TABLE `Dati_cliente`
  ADD PRIMARY KEY (`Email`);

--
-- Indici per le tabelle `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`Username`);

--
-- Indici per le tabelle `NonDisponibili`
--
ALTER TABLE `NonDisponibili`
  ADD PRIMARY KEY (`Data_Ora_Inizio`);

--
-- Indici per le tabelle `Prenotazioni`
--
ALTER TABLE `Prenotazioni`
  ADD PRIMARY KEY (`Data_Ora_Inizio`),
  ADD KEY `fk_cliente` (`Cliente`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Prenotazioni`
--
ALTER TABLE `Prenotazioni`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`Cliente`) REFERENCES `Dati_cliente` (`Email`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
