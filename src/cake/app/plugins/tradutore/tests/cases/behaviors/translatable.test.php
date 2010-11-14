<?php

/**
 * Test case class for Translatable behavior.
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

App::import('Model', 'Tradutore.Play');


/**
 * Test case for Translatable behavior.
 *
 * The test are perfomed via mock object Play.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class TranslatableTestCase extends CakeTestCase
{

    var $fixtures = array(
        'plugin.tradutore.play',
        'plugin.tradutore.play_translation'
    );

    var $Play;
    
    
    function startCase()
    {
        parent::startCase();
        $this->Play = ClassRegistry::init('Play');
    }

    
    function XtestFixtureSanity()
    {
        $this->Play->Behaviors->detach('Tradutore.Translatable');

        // Once test data is created and checked by a human being, use var_export to generate
        // the sanity check array.
        $expected = array (
          0 =>
          array (
            'Play' =>
            array (
              'id' => '1',
              'year' => '1606',
            ),
            'PlayTranslation' =>
            array (
              0 =>
              array (
                'id' => '1',
                'play_id' => '1',
                'language' => 'en',
                'title' => 'Antony and Cleopatra',
                'opening_excerpt' => 'Phil: Nay, but this dotage of our general\'s...',
              ),
              1 =>
              array (
                'id' => '2',
                'play_id' => '1',
                'language' => 'de',
                'title' => 'Antonius und Kleopatra',
                'opening_excerpt' => 'Phil: Nein, aber diese dotage unserer allgemeinen\'s...',
              ),
              2 =>
              array (
                'id' => '3',
                'play_id' => '1',
                'language' => 'uk',
                'title' => 'Антоній і Клеопатра',
                'opening_excerpt' => 'Філ: Ні, але це дитинство нашого генерала...',
              ),
              3 =>
              array (
                'id' => '4',
                'play_id' => '1',
                'language' => 'lv',
                'title' => 'Antony un Kleopatras',
                'opening_excerpt' => 'Phil: Nē, bet vecuma plānprātība mūsu vispārējo\'s...',
              ),
              4 =>
              array (
                'id' => '5',
                'play_id' => '1',
                'language' => 'nb',
                'title' => 'Antony and Cleopatra',
                'opening_excerpt' => 'Phil: Nei, men dette dotage av generell vår\'s...',
              ),
              5 =>
              array (
                'id' => '6',
                'play_id' => '1',
                'language' => 'el',
                'title' => 'Αντώνιος και Κλεοπάτρα',
                'opening_excerpt' => 'Phil: Όχι, αλλά αυτό ξεμωράματα της γενικής μας...',
              ),
            ),
          ),
          1 =>
          array (
            'Play' =>
            array (
              'id' => '2',
              'year' => '1605',
            ),
            'PlayTranslation' =>
            array (
              0 =>
              array (
                'id' => '7',
                'play_id' => '2',
                'language' => 'en',
                'title' => 'King Lear',
                'opening_excerpt' => 'Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall.',
              ),
              1 =>
              array (
                'id' => '8',
                'play_id' => '2',
                'language' => 'de',
                'title' => 'König Lear',
                'opening_excerpt' => 'Earl of Kent: Ich dachte, der König habe mehr der Herzog von Albany als Cornwall betroffen.',
              ),
              2 =>
              array (
                'id' => '9',
                'play_id' => '2',
                'language' => 'uk',
                'title' => 'Король Лір',
                'opening_excerpt' => 'Граф Кент: Я думав, короля було більше постраждалих герцог Олбані, ніж Корнуолл.',
              ),
              3 =>
              array (
                'id' => '10',
                'play_id' => '2',
                'language' => 'lv',
                'title' => 'Karalis Līrs',
                'opening_excerpt' => 'Earl of Kent: Es domāju, ka karalis bija vairāk ietekmējis hercoga Albany nekā Cornwall.',
              ),
              4 =>
              array (
                'id' => '11',
                'play_id' => '2',
                'language' => 'nb',
                'title' => 'King Lear',
                'opening_excerpt' => 'Jarlen av Kent: Jeg trodde kongen hadde mer påvirket hertug av Albany enn Cornwall.',
              ),
              5 =>
              array (
                'id' => '12',
                'play_id' => '2',
                'language' => 'el',
                'title' => 'Βασιλιάς Ληρ',
                'opening_excerpt' => 'Κόμης του Κεντ: Νόμιζα ότι ο βασιλιάς είχε επηρεάζεται περισσότερο ο Δούκας του Albany από την Κορνουάλη.',
              ),
            ),
          ),
          2 =>
          array (
            'Play' =>
            array (
              'id' => '3',
              'year' => '1589',
            ),
            'PlayTranslation' =>
            array (
              0 =>
              array (
                'id' => '13',
                'play_id' => '3',
                'language' => 'en',
                'title' => 'The Comedy of Errors',
                'opening_excerpt' => "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all.",
              ),
              1 =>
              array (
                'id' => '14',
                'play_id' => '3',
                'language' => 'de',
                'title' => 'Die Komödie der Irrungen',
                'opening_excerpt' => "Aegeon: Gehen, Solinus, zu beschaffen mein Fall\nUnd die Strafe des Todes Ende Leiden und alle.",
              ),
              2 =>
              array (
                'id' => '15',
                'play_id' => '3',
                'language' => 'uk',
                'title' => 'Комедія помилок',
                'opening_excerpt' => "Aegeon: Приступити Solinus, щоб забезпечити моє падіння\nІ дум про смерть наприкінці біди, і все.",
              ),
              3 =>
              array (
                'id' => '16',
                'play_id' => '3',
                'language' => 'lv',
                'title' => 'Komēdija kļūdu',
                'opening_excerpt' => "Aegeon: Rīkoties, Solinus, iegādāties manu kritumu\nUn ko liktenis nāves beigām woes un visiem.",
              ),
              4 =>
              array (
                'id' => '17',
                'play_id' => '3',
                'language' => 'nb',
                'title' => 'The Comedy of Errors',
                'opening_excerpt' => "Aegeon: Fortsett, Solinus, å anskaffe mitt fall\nOg ved undergangen hvor døden slutten woes og alle.",
              ),
              5 =>
              array (
                'id' => '18',
                'play_id' => '3',
                'language' => 'el',
                'title' => 'Η κωμωδία των παρεξηγήσεων',
                'opening_excerpt' => "Αιγαίον: Προχωρήστε, Solinus, να προμηθεύονται πτώση μου\nΚαι από τη μοίρα του δεινοπαθεί τέλος του θανάτου και όλα.",
              ),
            ),
          ),
          3 =>
          array (
            'Play' =>
            array (
              'id' => '4',
              'year' => '1599',
            ),
            'PlayTranslation' =>
            array (
              0 =>
              array (
                'id' => '19',
                'play_id' => '4',
                'language' => 'en',
                'title' => 'The Tragedy of Julius Caesar',
                'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?",
              ),
              1 =>
              array (
                'id' => '20',
                'play_id' => '4',
                'language' => 'de',
                'title' => 'Die Tragödie von Julius Cäsar',
                'opening_excerpt' => "Flavius: So! Zuhause, bekommen Sie im Leerlauf Kreaturen, die du zu Hause:\nIst das ein Feiertag?",
              ),
              2 =>
              array (
                'id' => '21',
                'play_id' => '4',
                'language' => 'uk',
                'title' => 'Трагедія Юлій Цезар',
                'opening_excerpt' => "Флавій: Геть! будинку, ви простою істот вас вдома:\nХіба це свято?",
              ),
              3 =>
              array (
                'id' => '22',
                'play_id' => '4',
                'language' => 'lv',
                'title' => 'Traģēdija Julius Caesar',
                'opening_excerpt' => "Flavius: Līdz! mājās, jūs tukšgaitas radības iegūt jums mājās:\nTas ir svētki?",
              ),
              4 =>
              array (
                'id' => '25',
                'play_id' => '4',
                'language' => 'nb',
                'title' => 'The Tragedy of Julius Caesar',
                'opening_excerpt' => "Flavius: Derfor! hjemme, du inaktiv skapninger få deg hjem:\nEr dette en ferie?",
              ),
              5 =>
              array (
                'id' => '26',
                'play_id' => '4',
                'language' => 'el',
                'title' => 'Η τραγωδία του Ιούλιου Καίσαρα',
                'opening_excerpt' => "Φλάβιο: Έτσι! σπίτι, σε αδράνεια πλάσματα να σας πάρει σπίτι:\nΕίναι αυτό διακοπές;",
              ),
            ),
          ),
          4 =>
          array (
            'Play' =>
            array (
              'id' => '5',
              'year' => '1600',
            ),
            'PlayTranslation' =>
            array (
              0 =>
              array (
                'id' => '27',
                'play_id' => '5',
                'language' => 'en',
                'title' => 'The Tragedy of Hamlet, Prince of Denmark',
                'opening_excerpt' => 'Bernardo: Who\'s there?',
              ),
              1 =>
              array (
                'id' => '28',
                'play_id' => '5',
                'language' => 'de',
                'title' => 'Die Tragödie von Hamlet, Prinz von Dänemark',
                'opening_excerpt' => 'Bernardo: Wer ist da?',
              ),
              2 =>
              array (
                'id' => '29',
                'play_id' => '5',
                'language' => 'uk',
                'title' => 'Трагедія Гамлета, принца данського',
                'opening_excerpt' => 'Бернардо: Хто там?',
              ),
              3 =>
              array (
                'id' => '30',
                'play_id' => '5',
                'language' => 'lv',
                'title' => 'Traģēdija ar Hamletu, Prince Dānijas',
                'opening_excerpt' => 'Bernardo: Kas tur ir?',
              ),
              4 =>
              array (
                'id' => '31',
                'play_id' => '5',
                'language' => 'nb',
                'title' => 'The Tragedy of Hamlet, prins av Danmark',
                'opening_excerpt' => 'Bernardo: Hvem er det?',
              ),
              5 =>
              array (
                'id' => '32',
                'play_id' => '5',
                'language' => 'el',
                'title' => 'Η τραγωδία του Άμλετ, Πρίγκιπα της Δανίας',
                'opening_excerpt' => 'Bernardo: Ποιος είναι εκεί?',
              ),
            ),
          ),
        );
        $result = $this->Play->find('all');

        $this->assertFalse(empty($result));
        $this->assertEqual($expected, $result);

        $this->Play->Behaviors->attach('Tradutore.Translatable');
    }


    function testGetSetLanguage()
    {
        $expected = Configure::read('Tradutore.default_language');
        $result = $this->Play->getLanguage();

        $this->assertEqual($expected, $result);

        $this->Play->setLanguage('uk');

        $expected = 'uk';
        $result = $this->Play->getLanguage();

        $this->assertEqual($expected, $result);
    }


    function testSingleLanguageQuery()
    {
        $this->Play->setLanguage('en');
        $query = array(
            'fields' => array('Play.title', 'Play.year'),
            'conditions' => array('Play.id' => 2)
        );

        $expected = array(
            'Play' => array('id' => 2, 'title' => 'King Lear', 'year' => 1605)
        );
        $result = $this->Play->find('first', $query);
        
        $this->assertEqual($expected, $result);
    }


    function XtestMultiLanguageQuery()
    {
    }

}

?>
