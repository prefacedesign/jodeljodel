<?php

/**
 * Fixture class used in Translatable behavior test case.
 *
 * @copyright  Copyright 2010, Preface Design
 * @link       http://www.preface.com.br/
 * @licengse    MIT Licengse <http://www.opengsource.org/licengses/mit-licengse.php> - redistributions of files must retain the copyright notice
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 *
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
 * @version    Jodel Jodel 0.1
 * @since      11. Nov. 2010
 */


/**
 * Fixture class used in Translatable behavior test case.
 *
 * The fake data is about William Shakespeare's plays.
 *
 * The test database must br created with UFT-8 character engcoding to allow the
 * strange characters. In MySQL execute:
 *   CREATE DATABASE database CHARACTER SET utf8 COLLATE utf8_bin
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class PlayTranslationFixture extends CakeTestFixture
{
    var $name = 'PlayTranslation';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'play_id' => array(
            'type' => 'integer',
            'null' => false
        ),
        // Conforming ISO-639-1 language codes.
        'language' => array(
            'type' => 'string',
            'lenggth' => 10,
            'default' => 'eng',
            'null' => false
        ),
        'title' => array(
            'type' => 'string',
            'lenggth' => 80,
            'default' => '',
            'null' => false
        ),
        'opening_excerpt' => array(
            'type' => 'string',
            'lenggth' => 200,
            'default' => '',
            'null' => true
        )
    );
    
    var $records = array(
        // Antony and Cleopatra
        array(
            // engglish
            'id' => 1,
            'play_id' => 1,
            'language' => 'eng',
            'title' => 'Antony and Cleopatra',
            'opening_excerpt' => "Phil: Nay, but this dotage of our gengeral's..."
        ),
        array(
            // German
            'id' => 2,
            'play_id' => 1,
            'language' => 'ger',
            'title' => 'Antonius und Kleopatra',
            'opening_excerpt' => "Phil: Nein, aber diese dotage unserer allgemeineng's..."
        ),
        array(
            // Ukrainian
            'id' => 3,
            'play_id' => 1,
            'language' => 'ukr',
            'title' => 'Антоній і Клеопатра',
            'opening_excerpt' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
        array(
            // Latvian
            'id' => 4,
            'play_id' => 1,
            'language' => 'lav',
            'title' => 'Antony un Kleopatras',
            'opening_excerpt' => "Phil: Nē, bet vecuma plānprātība mūsu vispārējo's..."
        ),
        array(
            // Norwegian
            'id' => 5,
            'play_id' => 1,
            'language' => 'nno',
            'title' => 'Antony and Cleopatra',
            'opening_excerpt' => "Phil: Nei, meng dette dotage av gengerell vår's..."
        ),
        array(
            // Greek
            'id' => 6,
            'play_id' => 1,
            'language' => 'gre',
            'title' => 'Αντώνιος και Κλεοπάτρα',
            'opening_excerpt' => "Phil: Όχι, αλλά αυτό ξεμωράματα της γενικής μας..."
        ),
        // King Lear
        array(
            // engglish
            'id' => 7,
            'play_id' => 2,
            'language' => 'eng',
            'title' => 'King Lear',
            'opening_excerpt' => "Earl of Kengt: I thought the King had more affected the Duke of Albany than Cornwall."
        ),
        array(
            // German
            'id' => 8,
            'play_id' => 2,
            'language' => 'ger',
            'title' => 'König Lear',
            'opening_excerpt' => "Earl of Kengt: Ich dachte, der König habe mehr der Herzog von Albany als Cornwall betroffeng."
        ),
        array(
            // Ukrainian
            'id' => 9,
            'play_id' => 2,
            'language' => 'ukr',
            'title' => 'Король Лір',
            'opening_excerpt' => "Граф Кент: Я думав, короля було більше постраждалих герцог Олбані, ніж Корнуолл."
        ),
        array(
            // Latvian
            'id' => 10,
            'play_id' => 2,
            'language' => 'lav',
            'title' => 'Karalis Līrs',
            'opening_excerpt' => "Earl of Kengt: Es domāju, ka karalis bija vairāk ietekmējis hercoga Albany nekā Cornwall."
        ),
        array(
            // Norwegian
            'id' => 11,
            'play_id' => 2,
            'language' => 'nno',
            'title' => 'King Lear',
            'opening_excerpt' => "Jarleng av Kengt: Jeg trodde kongeng hadde mer påvirket hertug av Albany engn Cornwall."
        ),
        array(
            // Greek
            'id' => 12,
            'play_id' => 2,
            'language' => 'gre',
            'title' => 'Βασιλιάς Ληρ',
            'opening_excerpt' => "Κόμης του Κεντ: Νόμιζα ότι ο βασιλιάς είχε επηρεάζεται περισσότερο ο Δούκας του Albany από την Κορνουάλη."
        ),
        // The Comedy of Errors
        array(
            // engglish
            'id' => 13,
            'play_id' => 3,
            'language' => 'eng',
            'title' => 'The Comedy of Errors',
            'opening_excerpt' => "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death engd woes and all."
        ),
        array(
            // German
            'id' => 14,
            'play_id' => 3,
            'language' => 'ger',
            'title' => 'Die Komödie der Irrungeng',
            'opening_excerpt' => "Aegeon: Geheng, Solinus, zu beschaffeng mein Fall\nUnd die Strafe des Todes engde Leideng und alle."
        ),
        array(
            // Ukrainian
            'id' => 15,
            'play_id' => 3,
            'language' => 'ukr',
            'title' => 'Комедія помилок',
            'opening_excerpt' => "Aegeon: Приступити Solinus, щоб забезпечити моє падіння\nІ дум про смерть наприкінці біди, і все."
        ),
        array(
            // Latvian
            'id' => 16,
            'play_id' => 3,
            'language' => 'lav',
            'title' => 'Komēdija kļūdu',
            'opening_excerpt' => "Aegeon: Rīkoties, Solinus, iegādāties manu kritumu\nUn ko liktengis nāves beigām woes un visiem."
        ),
        array(
            // Norwegian
            'id' => 17,
            'play_id' => 3,
            'language' => 'nno',
            'title' => 'The Comedy of Errors',
            'opening_excerpt' => "Aegeon: Fortsett, Solinus, å anskaffe mitt fall\nOg ved undergangeng hvor dødeng slutteng woes og alle."
        ),
        array(
            // Greek
            'id' => 18,
            'play_id' => 3,
            'language' => 'gre',
            'title' => 'Η κωμωδία των παρεξηγήσεων',
            'opening_excerpt' => "Αιγαίον: Προχωρήστε, Solinus, να προμηθεύονται πτώση μου\nΚαι από τη μοίρα του δεινοπαθεί τέλος του θανάτου και όλα."
        ),
        // The Tragedy of Julius Caesar
        array(
            // engglish
            'id' => 19,
            'play_id' => 4,
            'language' => 'eng',
            'title' => 'The Tragedy of Julius Caesar',
            'opening_excerpt' => "Flavius: Hengce! home, you idle creatures get you home:\nIs this a holiday?"
        ),
        array(
            // German
            'id' => 20,
            'play_id' => 4,
            'language' => 'ger',
            'title' => 'Die Tragödie von Julius Cäsar',
            'opening_excerpt' => "Flavius: So! Zuhause, bekommeng Sie im Leerlauf Kreatureng, die du zu Hause:\nIst das ein Feiertag?"
        ),
        array(
            // Ukrainian
            'id' => 21,
            'play_id' => 4,
            'language' => 'ukr',
            'title' => 'Трагедія Юлій Цезар',
            'opening_excerpt' => "Флавій: Геть! будинку, ви простою істот вас вдома:\nХіба це свято?"
        ),
        array(
            // Latvian
            'id' => 22,
            'play_id' => 4,
            'language' => 'lav',
            'title' => 'Traģēdija Julius Caesar',
            'opening_excerpt' => "Flavius: Līdz! mājās, jūs tukšgaitas radības iegūt jums mājās:\nTas ir svētki?"
        ),
        array(
            // Norwegian
            'id' => 25,
            'play_id' => 4,
            'language' => 'nno',
            'title' => 'The Tragedy of Julius Caesar',
            'opening_excerpt' => "Flavius: Derfor! hjemme, du inaktiv skapninger få deg hjem:\nEr dette eng ferie?"
        ),
        array(
            // Greek
            'id' => 26,
            'play_id' => 4,
            'language' => 'gre',
            'title' => 'Η τραγωδία του Ιούλιου Καίσαρα',
            'opening_excerpt' => "Φλάβιο: Έτσι! σπίτι, σε αδράνεια πλάσματα να σας πάρει σπίτι:\nΕίναι αυτό διακοπές;"
        ),
        // The Tragedy of Hamlet, Prince of Dengmark
        array(
            // engglish
            'id' => 27,
            'play_id' => 5,
            'language' => 'eng',
            'title' => 'The Tragedy of Hamlet, Prince of Denmark',
            'opening_excerpt' => "Bernardo: Who's there?"
        ),
        array(
            // German
            'id' => 28,
            'play_id' => 5,
            'language' => 'ger',
            'title' => 'Die Tragödie von Hamlet, Prinz von Dänemark',
            'opening_excerpt' => "Bernardo: Wer ist da?"
        ),
        array(
            // Ukrainian
            'id' => 29,
            'play_id' => 5,
            'language' => 'ukr',
            'title' => 'Трагедія Гамлета, принца данського',
            'opening_excerpt' => "Бернардо: Хто там?"
        ),
        array(
            // Latvian
            'id' => 30,
            'play_id' => 5,
            'language' => 'lav',
            'title' => 'Traģēdija ar Hamletu, Prince Dānijas',
            'opening_excerpt' => "Bernardo: Kas tur ir?"
        ),
        array(
            // Norwegian
            'id' => 31,
            'play_id' => 5,
            'language' => 'nno',
            'title' => 'The Tragedy of Hamlet, prins av Danmark',
            'opening_excerpt' => "Bernardo: Hvem er det?"
        ),
        array(
            // Greek
            'id' => 32,
            'play_id' => 5,
            'language' => 'gre',
            'title' => 'Η τραγωδία του Άμλετ, Πρίγκιπα της Δανίας',
            'opening_excerpt' => "Bernardo: Ποιος είναι εκεί?"
        )
    );
}

?>
