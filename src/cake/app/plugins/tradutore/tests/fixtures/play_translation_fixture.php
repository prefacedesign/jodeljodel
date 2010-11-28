<?php

/**
 * Fixture class used in Translatable behavior test case.
 *
 * @copyright  Copyright 2010, Preface Design
 * @link       http://www.preface.com.br/
 * @license    MIT License <http://www.opensource.org/licenses/mit-license.php> - redistributions of files must retain the copyright notice
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
 * The test database must br created with UFT-8 character encoding to allow the
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
            'length' => 10,
            'default' => 'en',
            'null' => false
        ),
        'title' => array(
            'type' => 'string',
            'length' => 80,
            'default' => '',
            'null' => false
        ),
        'opening_excerpt' => array(
            'type' => 'string',
            'length' => 200,
            'default' => '',
            'null' => true
        )
    );
    
    var $records = array(
        // Antony and Cleopatra
        array(
            // English
            'id' => 1,
            'play_id' => 1,
            'language' => 'en',
            'title' => 'Antony and Cleopatra',
            'opening_excerpt' => "Phil: Nay, but this dotage of our general's..."
        ),
        array(
            // German
            'id' => 2,
            'play_id' => 1,
            'language' => 'de',
            'title' => 'Antonius und Kleopatra',
            'opening_excerpt' => "Phil: Nein, aber diese dotage unserer allgemeinen's..."
        ),
        array(
            // Ukrainian
            'id' => 3,
            'play_id' => 1,
            'language' => 'uk',
            'title' => 'Антоній і Клеопатра',
            'opening_excerpt' => "Філ: Ні, але це дитинство нашого генерала..."
        ),
        array(
            // Latvian
            'id' => 4,
            'play_id' => 1,
            'language' => 'lv',
            'title' => 'Antony un Kleopatras',
            'opening_excerpt' => "Phil: Nē, bet vecuma plānprātība mūsu vispārējo's..."
        ),
        array(
            // Norwegian
            'id' => 5,
            'play_id' => 1,
            'language' => 'nb',
            'title' => 'Antony and Cleopatra',
            'opening_excerpt' => "Phil: Nei, men dette dotage av generell vår's..."
        ),
        array(
            // Greek
            'id' => 6,
            'play_id' => 1,
            'language' => 'el',
            'title' => 'Αντώνιος και Κλεοπάτρα',
            'opening_excerpt' => "Phil: Όχι, αλλά αυτό ξεμωράματα της γενικής μας..."
        ),
        // King Lear
        array(
            // English
            'id' => 7,
            'play_id' => 2,
            'language' => 'en',
            'title' => 'King Lear',
            'opening_excerpt' => "Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall."
        ),
        array(
            // German
            'id' => 8,
            'play_id' => 2,
            'language' => 'de',
            'title' => 'König Lear',
            'opening_excerpt' => "Earl of Kent: Ich dachte, der König habe mehr der Herzog von Albany als Cornwall betroffen."
        ),
        array(
            // Ukrainian
            'id' => 9,
            'play_id' => 2,
            'language' => 'uk',
            'title' => 'Король Лір',
            'opening_excerpt' => "Граф Кент: Я думав, короля було більше постраждалих герцог Олбані, ніж Корнуолл."
        ),
        array(
            // Latvian
            'id' => 10,
            'play_id' => 2,
            'language' => 'lv',
            'title' => 'Karalis Līrs',
            'opening_excerpt' => "Earl of Kent: Es domāju, ka karalis bija vairāk ietekmējis hercoga Albany nekā Cornwall."
        ),
        array(
            // Norwegian
            'id' => 11,
            'play_id' => 2,
            'language' => 'nb',
            'title' => 'King Lear',
            'opening_excerpt' => "Jarlen av Kent: Jeg trodde kongen hadde mer påvirket hertug av Albany enn Cornwall."
        ),
        array(
            // Greek
            'id' => 12,
            'play_id' => 2,
            'language' => 'el',
            'title' => 'Βασιλιάς Ληρ',
            'opening_excerpt' => "Κόμης του Κεντ: Νόμιζα ότι ο βασιλιάς είχε επηρεάζεται περισσότερο ο Δούκας του Albany από την Κορνουάλη."
        ),
        // The Comedy of Errors
        array(
            // English
            'id' => 13,
            'play_id' => 3,
            'language' => 'en',
            'title' => 'The Comedy of Errors',
            'opening_excerpt' => "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all."
        ),
        array(
            // German
            'id' => 14,
            'play_id' => 3,
            'language' => 'de',
            'title' => 'Die Komödie der Irrungen',
            'opening_excerpt' => "Aegeon: Gehen, Solinus, zu beschaffen mein Fall\nUnd die Strafe des Todes Ende Leiden und alle."
        ),
        array(
            // Ukrainian
            'id' => 15,
            'play_id' => 3,
            'language' => 'uk',
            'title' => 'Комедія помилок',
            'opening_excerpt' => "Aegeon: Приступити Solinus, щоб забезпечити моє падіння\nІ дум про смерть наприкінці біди, і все."
        ),
        array(
            // Latvian
            'id' => 16,
            'play_id' => 3,
            'language' => 'lv',
            'title' => 'Komēdija kļūdu',
            'opening_excerpt' => "Aegeon: Rīkoties, Solinus, iegādāties manu kritumu\nUn ko liktenis nāves beigām woes un visiem."
        ),
        array(
            // Norwegian
            'id' => 17,
            'play_id' => 3,
            'language' => 'nb',
            'title' => 'The Comedy of Errors',
            'opening_excerpt' => "Aegeon: Fortsett, Solinus, å anskaffe mitt fall\nOg ved undergangen hvor døden slutten woes og alle."
        ),
        array(
            // Greek
            'id' => 18,
            'play_id' => 3,
            'language' => 'el',
            'title' => 'Η κωμωδία των παρεξηγήσεων',
            'opening_excerpt' => "Αιγαίον: Προχωρήστε, Solinus, να προμηθεύονται πτώση μου\nΚαι από τη μοίρα του δεινοπαθεί τέλος του θανάτου και όλα."
        ),
        // The Tragedy of Julius Caesar
        array(
            // English
            'id' => 19,
            'play_id' => 4,
            'language' => 'en',
            'title' => 'The Tragedy of Julius Caesar',
            'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?"
        ),
        array(
            // German
            'id' => 20,
            'play_id' => 4,
            'language' => 'de',
            'title' => 'Die Tragödie von Julius Cäsar',
            'opening_excerpt' => "Flavius: So! Zuhause, bekommen Sie im Leerlauf Kreaturen, die du zu Hause:\nIst das ein Feiertag?"
        ),
        array(
            // Ukrainian
            'id' => 21,
            'play_id' => 4,
            'language' => 'uk',
            'title' => 'Трагедія Юлій Цезар',
            'opening_excerpt' => "Флавій: Геть! будинку, ви простою істот вас вдома:\nХіба це свято?"
        ),
        array(
            // Latvian
            'id' => 22,
            'play_id' => 4,
            'language' => 'lv',
            'title' => 'Traģēdija Julius Caesar',
            'opening_excerpt' => "Flavius: Līdz! mājās, jūs tukšgaitas radības iegūt jums mājās:\nTas ir svētki?"
        ),
        array(
            // Norwegian
            'id' => 25,
            'play_id' => 4,
            'language' => 'nb',
            'title' => 'The Tragedy of Julius Caesar',
            'opening_excerpt' => "Flavius: Derfor! hjemme, du inaktiv skapninger få deg hjem:\nEr dette en ferie?"
        ),
        array(
            // Greek
            'id' => 26,
            'play_id' => 4,
            'language' => 'el',
            'title' => 'Η τραγωδία του Ιούλιου Καίσαρα',
            'opening_excerpt' => "Φλάβιο: Έτσι! σπίτι, σε αδράνεια πλάσματα να σας πάρει σπίτι:\nΕίναι αυτό διακοπές;"
        ),
        // The Tragedy of Hamlet, Prince of Denmark
        array(
            // English
            'id' => 27,
            'play_id' => 5,
            'language' => 'en',
            'title' => 'The Tragedy of Hamlet, Prince of Denmark',
            'opening_excerpt' => "Bernardo: Who's there?"
        ),
        array(
            // German
            'id' => 28,
            'play_id' => 5,
            'language' => 'de',
            'title' => 'Die Tragödie von Hamlet, Prinz von Dänemark',
            'opening_excerpt' => "Bernardo: Wer ist da?"
        ),
        array(
            // Ukrainian
            'id' => 29,
            'play_id' => 5,
            'language' => 'uk',
            'title' => 'Трагедія Гамлета, принца данського',
            'opening_excerpt' => "Бернардо: Хто там?"
        ),
        array(
            // Latvian
            'id' => 30,
            'play_id' => 5,
            'language' => 'lv',
            'title' => 'Traģēdija ar Hamletu, Prince Dānijas',
            'opening_excerpt' => "Bernardo: Kas tur ir?"
        ),
        array(
            // Norwegian
            'id' => 31,
            'play_id' => 5,
            'language' => 'nb',
            'title' => 'The Tragedy of Hamlet, prins av Danmark',
            'opening_excerpt' => "Bernardo: Hvem er det?"
        ),
        array(
            // Greek
            'id' => 32,
            'play_id' => 5,
            'language' => 'el',
            'title' => 'Η τραγωδία του Άμλετ, Πρίγκιπα της Δανίας',
            'opening_excerpt' => "Bernardo: Ποιος είναι εκεί?"
        )
    );
}

?>
