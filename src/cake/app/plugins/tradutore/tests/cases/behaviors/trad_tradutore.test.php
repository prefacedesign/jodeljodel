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
App::import('Model', 'Tradutore.PlayTranslation');
App::import('Model', 'Tradutore.Author');
App::import('Model', 'Tradutore.AuthorTranslation');
App::import('Model', 'Tradutore.Image');
App::import('Model', 'Tradutore.Video');
App::import('Model', 'Tradutore.Bioinfo');
App::import('Model', 'Tradutore.BioinfoTranslation');
App::import('Model', 'Tradutore.Advertisement');
App::import('Model', 'Tradutore.AdvertisementTranslation');
App::import('Model', 'Tradutore.Scenario');
App::import('Model', 'Tradutore.ScenarioTranslation');
App::import('Model', 'Tradutore.Tag');
App::import('Model', 'Tradutore.TagTranslation');
App::import('Model', 'Tradutore.PlaysTag');


/**
 * Test case for Translatable behavior.
 *
 * The test are perfomed via mock object Play.
 *
 * @package    jodeljodel
 * @subpackage jodeljodel.tradutore.test
 */

class TradTradutoreTestCase extends CakeTestCase
{

    var $fixtures = array(
        'plugin.tradutore.play',
        'plugin.tradutore.play_translation',
		'plugin.tradutore.author',
		'plugin.tradutore.author_translation',
		'plugin.tradutore.image',
		'plugin.tradutore.video',
		'plugin.tradutore.bioinfo',
		'plugin.tradutore.bioinfo_translation',
		'plugin.tradutore.advertisement',
		'plugin.tradutore.advertisement_translation',
		'plugin.tradutore.scenario',
		'plugin.tradutore.scenario_translation',
		'plugin.tradutore.tag',
		'plugin.tradutore.tag_translation',
		'plugin.tradutore.plays_tag',
    );

    var $Play;
    var $PlayTranslation;
	var $Author;
	var $AuthorTranslation;
	var $Image;
	var $Video;
	var $Bioinfo;
	var $BioinfoTranslation;
	var $Advertisement;
	var $AdvertisementTranslation;
	var $Scenario;
	var $ScenarioTranslation;
	var $Tag;
	var $TagTranslation;
	var $PlaysTag;
    
    
    function startCase()
    {
        parent::startCase();

        $this->Play = ClassRegistry::init('Play');
        $this->PlayTranslation = ClassRegistry::init('PlayTranslation');
		$this->Author = ClassRegistry::init('Author');
        $this->AuthorTranslation = ClassRegistry::init('AuthorTranslation');
		$this->Image = ClassRegistry::init('Image');
		$this->Video = ClassRegistry::init('Video');
		$this->Bioinfo = ClassRegistry::init('Bioinfo');
		$this->BioinfoTranslation = ClassRegistry::init('BioinfoTranslation');
		$this->Advertisement = ClassRegistry::init('Advertisement');
		$this->AdvertisementTranslation = ClassRegistry::init('AdvertisementTranslation');
		$this->Scenario = ClassRegistry::init('Scenario');
		$this->ScenarioTranslation = ClassRegistry::init('ScenarioTranslation');
		$this->Tag = ClassRegistry::init('Tag');
		$this->TagTranslation = ClassRegistry::init('TagTranslation');
		$this->PlaysTag = ClassRegistry::init('PlaysTag');
    }

    
	
	/*
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
                'language' => 'eng',
                'title' => 'Antony and Cleopatra',
                'opening_excerpt' => 'Phil: Nay, but this dotage of our general\'s...',
              ),
              1 =>
              array (
                'id' => '2',
                'play_id' => '1',
                'language' => 'ger',
                'title' => 'Antonius und Kleopatra',
                'opening_excerpt' => 'Phil: Nein, aber diese dotage unserer allgemeinen\'s...',
              ),
              2 =>
              array (
                'id' => '3',
                'play_id' => '1',
                'language' => 'ukr',
                'title' => 'Антоній і Клеопатра',
                'opening_excerpt' => 'Філ: Ні, але це дитинство нашого генерала...',
              ),
              3 =>
              array (
                'id' => '4',
                'play_id' => '1',
                'language' => 'lav',
                'title' => 'Antony un Kleopatras',
                'opening_excerpt' => 'Phil: Nē, bet vecuma plānprātība mūsu vispārējo\'s...',
              ),
              4 =>
              array (
                'id' => '5',
                'play_id' => '1',
                'language' => 'nno',
                'title' => 'Antony and Cleopatra',
                'opening_excerpt' => 'Phil: Nei, men dette dotage av generell vår\'s...',
              ),
              5 =>
              array (
                'id' => '6',
                'play_id' => '1',
                'language' => 'gre',
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
                'language' => 'eng',
                'title' => 'King Lear',
                'opening_excerpt' => 'Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall.',
              ),
              1 =>
              array (
                'id' => '8',
                'play_id' => '2',
                'language' => 'ger',
                'title' => 'König Lear',
                'opening_excerpt' => 'Earl of Kent: Ich dachte, der König habe mehr der Herzog von Albany als Cornwall betroffen.',
              ),
              2 =>
              array (
                'id' => '9',
                'play_id' => '2',
                'language' => 'ukr',
                'title' => 'Король Лір',
                'opening_excerpt' => 'Граф Кент: Я думав, короля було більше постраждалих герцог Олбані, ніж Корнуолл.',
              ),
              3 =>
              array (
                'id' => '10',
                'play_id' => '2',
                'language' => 'lav',
                'title' => 'Karalis Līrs',
                'opening_excerpt' => 'Earl of Kent: Es domāju, ka karalis bija vairāk ietekmējis hercoga Albany nekā Cornwall.',
              ),
              4 =>
              array (
                'id' => '11',
                'play_id' => '2',
                'language' => 'nno',
                'title' => 'King Lear',
                'opening_excerpt' => 'Jarlen av Kent: Jeg trodde kongen hadde mer påvirket hertug av Albany enn Cornwall.',
              ),
              5 =>
              array (
                'id' => '12',
                'play_id' => '2',
                'language' => 'gre',
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
                'language' => 'eng',
                'title' => 'The Comedy of Errors',
                'opening_excerpt' => "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all.",
              ),
              1 =>
              array (
                'id' => '14',
                'play_id' => '3',
                'language' => 'ger',
                'title' => 'Die Komödie der Irrungen',
                'opening_excerpt' => "Aegeon: Gehen, Solinus, zu beschaffen mein Fall\nUnd die Strafe des Todes Ende Leiden und alle.",
              ),
              2 =>
              array (
                'id' => '15',
                'play_id' => '3',
                'language' => 'ukr',
                'title' => 'Комедія помилок',
                'opening_excerpt' => "Aegeon: Приступити Solinus, щоб забезпечити моє падіння\nІ дум про смерть наприкінці біди, і все.",
              ),
              3 =>
              array (
                'id' => '16',
                'play_id' => '3',
                'language' => 'lav',
                'title' => 'Komēdija kļūdu',
                'opening_excerpt' => "Aegeon: Rīkoties, Solinus, iegādāties manu kritumu\nUn ko liktenis nāves beigām woes un visiem.",
              ),
              4 =>
              array (
                'id' => '17',
                'play_id' => '3',
                'language' => 'nno',
                'title' => 'The Comedy of Errors',
                'opening_excerpt' => "Aegeon: Fortsett, Solinus, å anskaffe mitt fall\nOg ved undergangen hvor døden slutten woes og alle.",
              ),
              5 =>
              array (
                'id' => '18',
                'play_id' => '3',
                'language' => 'gre',
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
                'language' => 'eng',
                'title' => 'The Tragedy of Julius Caesar',
                'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?",
              ),
              1 =>
              array (
                'id' => '20',
                'play_id' => '4',
                'language' => 'ger',
                'title' => 'Die Tragödie von Julius Cäsar',
                'opening_excerpt' => "Flavius: So! Zuhause, bekommen Sie im Leerlauf Kreaturen, die du zu Hause:\nIst das ein Feiertag?",
              ),
              2 =>
              array (
                'id' => '21',
                'play_id' => '4',
                'language' => 'ukr',
                'title' => 'Трагедія Юлій Цезар',
                'opening_excerpt' => "Флавій: Геть! будинку, ви простою істот вас вдома:\nХіба це свято?",
              ),
              3 =>
              array (
                'id' => '22',
                'play_id' => '4',
                'language' => 'lav',
                'title' => 'Traģēdija Julius Caesar',
                'opening_excerpt' => "Flavius: Līdz! mājās, jūs tukšgaitas radības iegūt jums mājās:\nTas ir svētki?",
              ),
              4 =>
              array (
                'id' => '25',
                'play_id' => '4',
                'language' => 'nno',
                'title' => 'The Tragedy of Julius Caesar',
                'opening_excerpt' => "Flavius: Derfor! hjemme, du inaktiv skapninger få deg hjem:\nEr dette eng ferie?",
              ),
              5 =>
              array (
                'id' => '26',
                'play_id' => '4',
                'language' => 'gre',
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
                'language' => 'eng',
                'title' => 'The Tragedy of Hamlet, Prince of Denmark',
                'opening_excerpt' => 'Bernardo: Who\'s there?',
              ),
              1 =>
              array (
                'id' => '28',
                'play_id' => '5',
                'language' => 'ger',
                'title' => 'Die Tragödie von Hamlet, Prinz von Dänemark',
                'opening_excerpt' => 'Bernardo: Wer ist da?',
              ),
              2 =>
              array (
                'id' => '29',
                'play_id' => '5',
                'language' => 'ukr',
                'title' => 'Трагедія Гамлета, принца данського',
                'opening_excerpt' => 'Бернардо: Хто там?',
              ),
              3 =>
              array (
                'id' => '30',
                'play_id' => '5',
                'language' => 'lav',
                'title' => 'Traģēdija ar Hamletu, Prince Dānijas',
                'opening_excerpt' => 'Bernardo: Kas tur ir?',
              ),
              4 =>
              array (
                'id' => '31',
                'play_id' => '5',
                'language' => 'nno',
                'title' => 'The Tragedy of Hamlet, prins av Danmark',
                'opening_excerpt' => 'Bernardo: Hvem er det?',
              ),
              5 =>
              array (
                'id' => '32',
                'play_id' => '5',
                'language' => 'gre',
                'title' => 'Η τραγωδία του Άμλετ, Πρίγκιπα της Δανίας',
                'opening_excerpt' => 'Bernardo: Ποιος είναι εκεί?',
              ),
            ),
          ),
        );
        $result = $this->Play->find('all');
		debug($result);
		die;
		
        $this->assertFalse(empty($result));
        $this->assertEqual($expected, $result);
		
		
        $this->Play->Behaviors->attach('Tradutore.Translatable');
		
    }
	
	*/
	
	
	
    function testGetSetLanguage()
    {
        $expected = Configure::read('Tradutore.mainLanguage');
		$this->Play->setLanguage('por');
        $result = $this->Play->getLanguage();
        $this->assertEqual($expected, $result);

        $this->Play->setLanguage('ukr');

        $expected = 'ukr';
        $result = $this->Play->getLanguage();


        $this->assertEqual($expected, $result);
    }

	/*
	function testSimplesFinds()
    {
		$this->Play->setLanguage('eng');
		$this->Play->recursive = -1;
        $result = $this->Play->findById(1);
		
		$expected = array(
			'Play' => array(
				'id' => 1, 
				'author_id' => 1, 
				'language' => 'eng', 
				'title' => 'Antony and Cleopatra', 
				'year' => 1606,
				'play_id' => 1,
				'opening_excerpt' => "Phil: Nay, but this dotage of our gengeral's..."
			)
        );
        $this->assertEqual($expected, $result);
		
		
		$this->Play->recursive = 0;
        $result = $this->Play->findById(1);
		//debug($result);
		
		$expected = array(
			'Play' => array(
				'id' => 1, 
				'author_id' => 1, 
				'language' => 'eng', 
				'title' => 'Antony and Cleopatra', 
				'year' => 1606,
				'play_id' => 1,
				'opening_excerpt' => "Phil: Nay, but this dotage of our gengeral's..."
			),
			'Author' => array(
				'id' => 1,
				'name' => 'Shakespeare',
				'author_id' => 1,
				'language' => 'eng',
				'nacionality' => 'English'
			),
			'Scenario' => array(
				'id' => 1,
				'play_id' => 1,
				'number_of_objects' => 70,
				'scenario_id' => 1,
				'language' => 'eng',
				'concept' => 'Classic'
			),
        );
        $this->assertEqual($expected, $result);
		
		
		
		$this->Play->recursive = 1;
        $result = $this->Play->findById(1);
		//debug($result);
		
		$expected = array(
			'Play' => array(
				'id' => 1, 
				'author_id' => 1, 
				'language' => 'eng', 
				'title' => 'Antony and Cleopatra', 
				'year' => 1606,
				'play_id' => 1,
				'opening_excerpt' => "Phil: Nay, but this dotage of our gengeral's..."
			),
			'Author' => array(
				'id' => 1,
				'name' => 'Shakespeare',
				'author_id' => 1,
				'language' => 'eng',
				'nacionality' => 'English'
			),
			'Scenario' => array(
				'id' => 1,
				'play_id' => 1,
				'number_of_objects' => 70,
				'scenario_id' => 1,
				'language' => 'eng',
				'concept' => 'Classic'
			),
			'Image' => array(
				0 => array(						
					'id' => 1,
					'play_id' => 1,
					'author_id' => null,
					'file' => 'teste.bmp'
				),
				1 => array(						
					'id' => 2,
					'play_id' => 1,
					'author_id' => null,
					'file' => 'oficial.bmp'
				)
			),
			'Advertisement' => array(
				0 => array(
					'id' => 1,
					'play_id' => 1,
					'advertisement_id' => 1,
					'language' => 'eng',
					'advertisement' => "Antony and Cleopatra is a tragedy by William Shakespeare, believed to have been written sometime between 1603 and 1607. It was first printed in the First Folio of 1623. The plot is based on Thomas North's translation of Plutarch's Life of Marcus Antonius and follows the relationship between Cleopatra and Mark Antony from the time of the Parthian War to Cleopatra's suicide. The major antagonist is Octavius Caesar, one of Antony's fellow triumviri and the future first emperor of Rome. The tragedy is a Roman play characterized by swift, panoramic shifts in geographical locations and in registers, alternating between sensual, imaginative Alexandria and the more pragmatic, austere Rome."
				),
				1 => array(
					'id' => 2,
					'play_id' => 1,
					'advertisement_id' => 2,
					'language' => 'eng',
					'advertisement' => "Mark Antony – one of the Triumvirs of Rome along with Octavian and Marcus Aemilius Lepidus – has neglected his soldierly duties after being beguiled by Egypt's Queen, Cleopatra VII. He ignores Rome's domestic problems, including the fact that his third wife Fulvia rebelled against Octavian and then died."
				)
			),
			'Tag' => array(
				0 => array(
					'id' => 1,
					'tag_id' => 1,
					'language' => 'eng',
					'tag' => 'cool',
				),
				1 => array(
					'id' => 2,
					'tag_id' => 2,
					'language' => 'eng',
					'tag' => 'beautiful'
				),
				2 => array(
					'id' => 3,
					'tag_id' => 3,
					'language' => 'eng',
					'tag' => 'horrendous'
				)
			)
        );
        $this->assertEqual($expected, $result);
		
	}
	
	function testRecursiveFind()
    {
		$this->Play->recursive = 2;
        $result = $this->Play->findById(1);
		//debug($result);
		
		$expected = array(
			'Play' => array(
				'id' => 1, 
				'author_id' => 1, 
				'language' => 'eng', 
				'title' => 'Antony and Cleopatra', 
				'year' => 1606,
				'play_id' => 1,
				'opening_excerpt' => "Phil: Nay, but this dotage of our gengeral's..."
			),
			'Author' => array(
				'id' => 1,
				'name' => 'Shakespeare',
				'author_id' => 1,
				'language' => 'eng',
				'nacionality' => 'English',
				'Image' => array(
					0 => array(						
						'id' => 11,
						'play_id' => null,
						'author_id' => 1,
						'file' => 'Shakespeare.bmp'
					)
				),
				'Bioinfo' => array(
					0 => array(						
						'id' => 1,
						'author_id' => 1,
						'bioinfo_id' => 1,
						'language' => 'eng',
						'type' => 'secret',
						'info' => "Phil: Nay, but this dotage of our general's..."
					),
					1 => array(						
						'id' => 2,
						'author_id' => 1,
						'bioinfo_id' => 2,
						'language' => 'eng',
						'type' => 'open',
						'info' => "Phil: Nay, but this dotage of our general's..."
					)
				),
				'Video' => array(
					0 => array(						
						'id' => 1,
						'author_translation_id' => 1,
						'file' => 'Shakespeare life.avi'
					)
				),
			),
			'Scenario' => array(
				'id' => 1,
				'play_id' => 1,
				'number_of_objects' => 70,
				'scenario_id' => 1,
				'language' => 'eng',
				'concept' => 'Classic'
			),
			'Image' => array(
				0 => array(						
					'id' => 1,
					'play_id' => 1,
					'author_id' => null,
					'file' => 'teste.bmp'
				),
				1 => array(						
					'id' => 2,
					'play_id' => 1,
					'author_id' => null,
					'file' => 'oficial.bmp'
				)
			),
			'Advertisement' => array(
				0 => array(
					'id' => 1,
					'play_id' => 1,
					'advertisement_id' => 1,
					'language' => 'eng',
					'advertisement' => "Antony and Cleopatra is a tragedy by William Shakespeare, believed to have been written sometime between 1603 and 1607. It was first printed in the First Folio of 1623. The plot is based on Thomas North's translation of Plutarch's Life of Marcus Antonius and follows the relationship between Cleopatra and Mark Antony from the time of the Parthian War to Cleopatra's suicide. The major antagonist is Octavius Caesar, one of Antony's fellow triumviri and the future first emperor of Rome. The tragedy is a Roman play characterized by swift, panoramic shifts in geographical locations and in registers, alternating between sensual, imaginative Alexandria and the more pragmatic, austere Rome."
				),
				1 => array(
					'id' => 2,
					'play_id' => 1,
					'advertisement_id' => 2,
					'language' => 'eng',
					'advertisement' => "Mark Antony – one of the Triumvirs of Rome along with Octavian and Marcus Aemilius Lepidus – has neglected his soldierly duties after being beguiled by Egypt's Queen, Cleopatra VII. He ignores Rome's domestic problems, including the fact that his third wife Fulvia rebelled against Octavian and then died."
				)
			),
			'Tag' => array(
				0 => array(
					'id' => 1,
					'tag_id' => 1,
					'language' => 'eng',
					'tag' => 'cool',
				),
				1 => array(
					'id' => 2,
					'tag_id' => 2,
					'language' => 'eng',
					'tag' => 'beautiful'
				),
				2 => array(
					'id' => 3,
					'tag_id' => 3,
					'language' => 'eng',
					'tag' => 'horrendous'
				)
			)
        );
        $this->assertEqual($expected, $result);
    }
	
	
	
	function testFindWithoutContainOrFields()
    {
        $this->Play->setLanguage('eng');
        $result = $this->Play->find('first', array('recursive' => 1));
		$expected = array(
			'Play' => array(
				'id' => 1, 
				'author_id' => 1, 
				'language' => 'eng', 
				'title' => 'Antony and Cleopatra', 
				'year' => 1606,
				'play_id' => 1,
				'opening_excerpt' => "Phil: Nay, but this dotage of our gengeral's..."
			),
			'Author' => array(
				'id' => 1,
				'name' => 'Shakespeare',
				'author_id' => 1,
				'language' => 'eng',
				'nacionality' => 'English'
			),
			'Scenario' => array(
				'id' => 1,
				'play_id' => 1,
				'number_of_objects' => 70,
				'scenario_id' => 1,
				'language' => 'eng',
				'concept' => 'Classic',
			),
			'Image' => array(
				0 => array(						
					'id' => 1,
					'play_id' => 1,
					'author_id' => null,
					'file' => 'teste.bmp'
				),
				1 => array(						
					'id' => 2,
					'play_id' => 1,
					'author_id' => null,
					'file' => 'oficial.bmp'
				)
			),
			'Advertisement' => array(
				0 => array(
					'id' => 1,
					'play_id' => 1,
					'advertisement_id' => 1,
					'language' => 'eng',
					'advertisement' => "Antony and Cleopatra is a tragedy by William Shakespeare, believed to have been written sometime between 1603 and 1607. It was first printed in the First Folio of 1623. The plot is based on Thomas North's translation of Plutarch's Life of Marcus Antonius and follows the relationship between Cleopatra and Mark Antony from the time of the Parthian War to Cleopatra's suicide. The major antagonist is Octavius Caesar, one of Antony's fellow triumviri and the future first emperor of Rome. The tragedy is a Roman play characterized by swift, panoramic shifts in geographical locations and in registers, alternating between sensual, imaginative Alexandria and the more pragmatic, austere Rome.",
				),
				1 => array(
					'id' => 2,
					'play_id' => 1,
					'advertisement_id' => 2,
					'language' => 'eng',
					'advertisement' => "Mark Antony – one of the Triumvirs of Rome along with Octavian and Marcus Aemilius Lepidus – has neglected his soldierly duties after being beguiled by Egypt's Queen, Cleopatra VII. He ignores Rome's domestic problems, including the fact that his third wife Fulvia rebelled against Octavian and then died."
				)
			),
			'Tag' => array(
				0 => array(
					'id' => 1,
					'tag_id' => 1,
					'language' => 'eng',
					'tag' => 'cool',
				),
				1 => array(
					'id' => 2,
					'tag_id' => 2,
					'language' => 'eng',
					'tag' => 'beautiful',
				),
				2 => array(
					'id' => 3,
					'tag_id' => 3,
					'language' => 'eng',
					'tag' => 'horrendous',
				)
			)
        );
		//debug($result);
        $this->assertEqual($expected, $result);
		
    }

	*/
		
	function testOtherSimplesFinds()
    {
		$this->Play->setLanguage('eng');
		
		$result = $this->Play->find('count');
		$expected = 5;
        $this->assertEqual($expected, $result);
		
		$result = $this->Play->find('count', array('fields' => 'DISTINCT Play.id'));
		$expected = 5;
        $this->assertEqual($expected, $result);
		
		
		$result = $this->Play->find('count', array('conditions' => array('Play.year >' => 1600)));
		$expected = 2;
        $this->assertEqual($expected, $result); 
		
		$result = $this->Play->find('count', array('conditions' => array('Play.year >=' => 1600)));
		$expected = 3;
        $this->assertEqual($expected, $result); 
		
		$this->Play->setLanguage('por');
		$result = $this->Play->find('count');
		$expected = 1;
		$this->assertEqual($expected, $result); 
		
		
        $result = $this->Play->find('list');
		$expected = array(
			5 => 'Aqui vai um título qualquer em português'
		);
        $this->assertEqual($expected, $result);
		
	}
	
	
    function testSingleLanguageQuery()
    {
        $this->Play->setLanguage('eng');
        $query = array(
			'fields' => array('Play.title'),
            'conditions' => array('Play.id' => 2)
        );

        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605)
        );
        $result = $this->Play->find('first', $query);
        $this->assertEqual($expected, $result);
		
		
		//$this->Play->PlayTranslation->deleteAll(array('play_id' => 2));
		$this->Play->Scenario->delete(2);
		$result = $this->Play->Scenario->findById(2);
		$this->assertEqual('', $result);
		$this->Play->delete(2);
		$result = $this->Play->findById(2);
		$this->assertEqual('', $result);
    }
	
	
	
	
	function testSingleLanguageQueryWithCascade()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2)
        );

        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array('name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng')
        );
        $result = $this->Play->find('first', $query);
        $this->assertEqual($expected, $result);
    }
	
	
	
	function testMultipleRecordsInSingleLanguageQuery()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title')
        );
		
		
        $expected = array(
			0 => array('Play' => array('id' => 1, 'author_id' => 1, 'language' => 'eng', 'title' => 'Antony and Cleopatra', 'year' => 1606)),
			1 => array('Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605)),
			2 => array('Play' => array('id' => 3, 'author_id' => 1, 'language' => 'eng', 'title' => 'The Comedy of Errors', 'year' => 1589)),
			3 => array('Play' => array('id' => 4, 'author_id' => 2, 'language' => 'eng', 'title' => 'The Tragedy of Julius Caesar', 'year' => 1599)),
			4 => array('Play' => array('id' => 5, 'author_id' => 2, 'language' => 'eng', 'title' => 'The Tragedy of Hamlet, Prince of Denmark', 'year' => 1600)),
        );

        $result = $this->Play->find('all', $query);
		//debug($result);
		//die;
        $this->assertEqual($expected, $result);
    }
	
	function testMultipleRecordsInSingleLanguageQueryWithCascade()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name')
        );
		
		
        $expected = array(
			0 => array('Play' => array('id' => 1, 'author_id' => 1, 'language' => 'eng', 'title' => 'Antony and Cleopatra', 'year' => 1606), 'Author' => array('name' => 'Shakespeare')),
			1 => array('Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605), 'Author' => array('name' => 'Shakespeare')),
			2 => array('Play' => array('id' => 3, 'author_id' => 1, 'language' => 'eng', 'title' => 'The Comedy of Errors', 'year' => 1589), 'Author' => array('name' => 'Shakespeare')),
			3 => array('Play' => array('id' => 4, 'author_id' => 2, 'language' => 'eng', 'title' => 'The Tragedy of Julius Caesar', 'year' => 1599), 'Author' => array('name' => 'Italo Calvino')),
			4 => array('Play' => array('id' => 5, 'author_id' => 2, 'language' => 'eng', 'title' => 'The Tragedy of Hamlet, Prince of Denmark', 'year' => 1600), 'Author' => array('name' => 'Italo Calvino')),
        );

        $result = $this->Play->find('all', $query);
		//debug($result);
		//die;
        $this->assertEqual($expected, $result);
    }
	
	
	
	function testMultipleRecordsInSingleLanguageQueryWithCascade2()
    {
        $this->Play->setLanguage('ukr');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality')
        );
		
		
        $expected = array(
			0 => array('Play' => array('id' => 1, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Антоній і Клеопатра', 'year' => 1606), 'Author' => array('id' => 1, 'name' => 'Shakespeare', 'language' => 'ukr', 'nacionality' => 'Англійська')),
			1 => array('Play' => array('id' => 2, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Король Лір', 'year' => 1605), 'Author' => array('id' => 1, 'name' => 'Shakespeare', 'language' => 'ukr', 'nacionality' => 'Англійська')),
			2 => array('Play' => array('id' => 3, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Комедія помилок', 'year' => 1589), 'Author' => array('id' => 1, 'name' => 'Shakespeare', 'language' => 'ukr', 'nacionality' => 'Англійська')),
			3 => array('Play' => array('id' => 4, 'author_id' => 2, 'language' => 'ukr', 'title' => 'Трагедія Юлій Цезар', 'year' => 1599), 'Author' => array('id' => 2, 'name' => 'Italo Calvino', 'language' => 'ukr', 'nacionality' => 'Італійський')),
			4 => array('Play' => array('id' => 5, 'author_id' => 2, 'language' => 'ukr', 'title' => 'Трагедія Гамлета, принца данського', 'year' => 1600), 'Author' => array('id' => 2, 'name' => 'Italo Calvino', 'language' => 'ukr', 'nacionality' => 'Італійський')),
        );

        $result = $this->Play->find('all', $query);
		//debug($result);
		//die;
        $this->assertEqual($expected, $result);
    }
	
	
	function testSingleLanguageQueryWithCascadeAndWithMoreModels()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality', 'Image.file'),
            'conditions' => array('Play.id' => 2)
        );

        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array('name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng'),
			'Image' => array(
				0 => array('file' => 'muito_legal.bmp', 'play_id' => 2),
				1 => array('file' => 'show.bmp', 'play_id' => 2)
			)
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
    }
	
	
	
	function testSingleLanguageQueryWithCascadeAndWithMoreModels2()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Author' => array('Image' => array('fields' => array('file'))))
        );

        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
				'Image' => array(
					0 => array('id' => 11, 'file' => 'Shakespeare.bmp', 'author_id' => 1),
				)
			),
			
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
    }
	
	
	function testSingleLanguageQueryWithCascadeAndWithMoreModels3()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Author' => array('Video' => array('fields' => array('file'))))
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
				'Video' => array(
					0 => array('id' => 1, 'file' => 'Shakespeare life.avi', 'author_translation_id' => 1),
				)
			),
			
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
		//die;
		
		
		
		$this->Play->setLanguage('ukr');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Author' => array('Video' => array('fields' => array('file'))))
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Король Лір', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'Англійська', 'language' => 'ukr',
				'Video' => array(
					0 => array('id' => 2, 'file' => 'Шекспір життя.avi', 'author_translation_id' => 3),
				)
			),
			
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
		$this->assertEqual($expected, $result);
		
    }
	
	
	function testSingleLanguageQueryWithCascadeAndWithMoreModels4()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Author' => array('Bioinfo' => array('fields' => array('Bioinfo.type', 'Bioinfo.info'))))
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
				'Bioinfo' => array(
					0 => array('id' => 1, 'author_id' => 1, 'type' => 'secret', 'info' => "Phil: Nay, but this dotage of our general's...", 'language' => 'eng'),
					1 => array('id' => 2, 'author_id' => 1, 'type' => 'open',  'info' => "Phil: Nay, but this dotage of our general's...", 'language' => 'eng'),
				)
			),
			
        );
        $result = $this->Play->find('first', $query);
        $this->assertEqual($expected, $result);
		
		$this->Play->setLanguage('ukr');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Author' => array('Bioinfo' => array('fields' => array('Bioinfo.type', 'Bioinfo.info'))))
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Король Лір', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'Англійська', 'language' => 'ukr',
				'Bioinfo' => array(
					0 => array('id' => 1, 'author_id' => 1, 'type' => 'генераt', 'info' => "Філ: Ні, але це дитинство нашого генерала...", 'language' => 'ukr'),
					1 => array('id' => 2, 'author_id' => 1, 'type' => 'ерot',  'info' => "Філ: Ні, але це дитинство нашого генерала...", 'language' => 'ukr'),
				),
			),
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
		
		$result = $this->Play->find('first', $query);
        $this->assertEqual($expected, $result);
		
		$this->Play->setLanguage('ger');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 4),
			'contain' => array('Author' => array('Bioinfo' => array('fields' => array('Bioinfo.type', 'Bioinfo.info'))))
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 4, 'author_id' => 2, 'language' => 'ger', 'title' => 'Die Tragödie von Julius Cäsar', 'year' => 1599),
			'Author' => array(
				'name' => 'Italo Calvino', 'id' => 2, 'nacionality' => 'Italienisch', 'language' => 'ger',
				'Bioinfo' => array(
					0 => array('id' => 3, 'author_id' => 2, 'type' => 'upen', 'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's...", 'language' => 'ger'),
					1 => array('id' => 4, 'author_id' => 2, 'type' => 'segrein',  'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's...", 'language' => 'ger'),
					2 => array('id' => 5, 'author_id' => 2, 'type' => 'segrein',  'info' => "Phil: Nein, aber diese dotage unserer allgemeinen's...", 'language' => 'ger'),
				)
			),
			
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
    }
	
	
	function testAHasManyWithTranslation()
    {
        $this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality'),
            'conditions' => array('Play.id' => 2),
			'contain' => array(
				'Author' => array(
					'Bioinfo' => array(
						'fields' => array('Bioinfo.type', 'Bioinfo.info')
					)
				),
				'Advertisement' => array(
					'fields' => array('Advertisement.advertisement')
				)
			)
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
				'Bioinfo' => array(
					0 => array('id' => 1, 'author_id' => 1, 'type' => 'secret', 'info' => "Phil: Nay, but this dotage of our general's...", 'language' => 'eng'),
					1 => array('id' => 2, 'author_id' => 1, 'type' => 'open',  'info' => "Phil: Nay, but this dotage of our general's...", 'language' => 'eng'),
				)
			),
			'Advertisement' => array(
				0 => array('id' => 3, 'play_id' => 2, 'advertisement' => "King Lear is a tragedy by William Shakespeare, considered to be one of his greatest dramatic masterpieces. The title character descends into madness after foolishly disposing of his estate between two of his three daughters based on their flattery, bringing tragic consequences for all. The play is based on the legend of Leir of Britain, a mythological pre-Roman Celtic king. It has been widely adapted for the stage and motion pictures, and the role of Lear has been coveted and played by many of the world's most accomplished actors.", 'language' => 'eng'),
				1 => array('id' => 4, 'play_id' => 2, 'advertisement' => "King Lear, who is elderly, wants to retire from power. He decides to divide his realm among his three daughters, and offers the largest share to the one who loves him best. Goneril and Regan both proclaim in fulsome terms that they love him more than anything in the world, which pleases him. For Cordelia, there is nothing to compare her love to, nor words to properly express it; she speaks honestly; but bluntly which infuriates him. In his anger he disinherits her, and divides the kingdom between Regan and Goneril. Kent objects to this unfair treatment. Lear is further enraged by Kent's protests, and banishes him from the country. Cordelia's two suitors enter. Learning that Cordelia has been disinherited, the Duke of Burgundy withdraws his suit, but the King of France is impressed by her honesty and marries her.", 'language' => 'eng'),
			)
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
		
		
		$this->Play->setLanguage('ukr');
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Король Лір', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'Англійська', 'language' => 'ukr',
				'Bioinfo' => array(
					0 => array('id' => 1, 'author_id' => 1, 'type' => 'генераt', 'info' => "Філ: Ні, але це дитинство нашого генерала...", 'language' => 'ukr'),
					1 => array('id' => 2, 'author_id' => 1, 'type' => 'ерot',  'info' => "Філ: Ні, але це дитинство нашого генерала...", 'language' => 'ukr'),
				)
			),
			'Advertisement' => array(
				0 => array('id' => 3, 'play_id' => 2, 'advertisement' => "Король Лір трагедії Вільяма Шекспіра, вважається одним з його найбільших драматичних шедеврів. Назва символу спускається в безумство після нерозумно утилізації свій маєток між двома з трьох його дочок на основі їх лестощами, приносячи трагічні наслідки для всіх. П'єса заснована на легенді про Лір Великобританії, міфологічні доримского кельтський король. Він був широко адаптований для сцени і кіно, а роль Ліра була бажаною і грають багато з найвідоміших акторів світу.", 'language' => 'ukr'),
				1 => array('id' => 4, 'play_id' => 2, 'advertisement' => "Король Лір, який знаходиться в похилому віці, хоче відійти від влади. Він вирішує розділити своє царство серед своїх трьох дочок, і пропонує найбільшу частку до того, хто любить його кращим. Гонерілья і Регана і проголосити в груба умови, що вони люблять його більше, ніж що-небудь у світі, який йому подобається. Для Корделія, немає нічого, щоб порівняти її із задоволенням, ні слова, щоб правильно висловити це, вона говорить щиро, але прямо яка дратує його. У гніві він disinherits її, і ділить королівство між Регана і Гонерілья. Кент заперечує проти цього несправедливого поводження. Лір далі лють протести Кента, і виганяє його з країни. Корделії двох наречених увійти. Дізнавшись, що Корделія була знедолених, герцога Бургундського відкликає свій позов, але король Франції вражений її чесності і одружується з нею.", 'language' => 'ukr'),
			)
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
		
		
		$this->Play->setLanguage('eng');
        $query = array(
            'fields' => array('Play.title'),
            'conditions' => array('Play.id' => 3),
			'contain' => array(
				'Advertisement' => array(
					'fields' => array('Advertisement.advertisement')
				)
			)
        );
		//debug($this->AuthorTranslation);
        $expected = array(
            'Play' => array('id' => 3, 'author_id' => 1, 'language' => 'eng', 'title' => 'The Comedy of Errors', 'year' => 1589),
			'Advertisement' => array(
				0 => array('id' => 5, 'play_id' => 3, 'advertisement' => "The Comedy of Errors is one of William Shakespeare's earliest plays, believed to have been written between 1592 and 1594. It is his shortest and one of his most farcical comedies, with a major part of the humour coming from slapstick and mistaken identity, in addition to puns and word play. The Comedy of Errors (along with The Tempest) is one of only two of Shakespeare's plays to observe the classical unities. It has been adapted for opera, stage, screen and musical theatre.", 'language' => 'eng'),
				1 => array('id' => 6, 'play_id' => 3, 'advertisement' => "The Comedy of Errors tells the story of two sets of identical twins that were accidentally separated at birth. Antipholus of Syracuse and his servant, Dromio of Syracuse, arrive in Ephesus, which turns out to be the home of their twin brothers, Antipholus of Ephesus and his servant, Dromio of Ephesus. When the Syracusans encounter the friends and families of their twins, a series of wild mishaps based on mistaken identities lead to wrongful beatings, a near-seduction, the arrest of Antipholus of Ephesus, and accusations of infidelity, theft, madness, and demonic possession.", 'language' => 'eng'),
				2 => array('id' => 7, 'play_id' => 3, 'advertisement' => "Due to a law forbidding the presence of Syracusian merchants in Ephesus, elderly Syracusian trader Egeon faces execution when he is discovered in the city. He can only escape by paying a fine of a thousand marks. He tells his sad story to the Duke. In his youth, he married and had twin sons. On the same day, a poor woman also gave birth to twin boys, and he purchased these as slaves to his sons. Soon afterwards, the family made a sea voyage, and was hit by a tempest. Egeon lashed himself to the main-mast with one son and one slave, while his wife was rescued by one boat, Egeon by another. Egeon never again saw his wife, or the children with her. Recently, his son Antipholus of Syracuse, now grown, and his son’s slave Dromio of Syracuse, left Syracuse on a quest to find their brothers. When Antipholus of Syracuse did not return, Egeon set out in search of him.", 'language' => 'eng'),
			)
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
    }
	
	
	
	function testAHasOneWithTranslation()
    {
        $this->Play->setLanguage('eng');
		
		$query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality', 'Scenario.number_of_objects', 'Scenario.concept'),
            'conditions' => array('Play.id' => 2)
        );

        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
			),
			'Scenario' => array('id' => 2, 'number_of_objects' => 120, 'concept' => 'Modern', 'language' => 'eng'),
			
        );
        $result = $this->Play->find('first', $query);
        $this->assertEqual($expected, $result);
		
		
		$this->Play->setLanguage('ukr');
		$expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Король Лір', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'Англійська', 'language' => 'ukr',
			),
			'Scenario' => array('id' => 2, 'number_of_objects' => 120, 'concept' => 'Сучасна', 'language' => 'ukr'),
			
        );
        $result = $this->Play->find('first', $query);
        $this->assertEqual($expected, $result);
		
		
		
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality', 'Scenario.number_of_objects', 'Scenario.concept'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Author' => array('Image' => array('fields' => array('file'))))
        );

		$this->Play->setLanguage('eng');
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
				'Image' => array(
					0 => array('id' => 11, 'file' => 'Shakespeare.bmp', 'author_id' => 1),
				)
			),
			'Scenario' => array('id' => 2, 'number_of_objects' => 120, 'concept' => 'Modern', 'language' => 'eng'),
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
		
    }
	
	
	function testHABTMWithTranslation()
    {
		
        $this->Play->setLanguage('eng');
		
        $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality', 'Scenario.number_of_objects', 'Scenario.concept'),
            'conditions' => array('Play.id' => 2),
			'contain' => array('Tag' => array('fields' => array('tag')))
        );

		$this->Play->setLanguage('eng');
        $expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'eng', 'title' => 'King Lear', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'English', 'language' => 'eng',
			),
			'Scenario' => array('id' => 2, 'number_of_objects' => 120, 'concept' => 'Modern', 'language' => 'eng'),
			'Tag' => array(
				0 => array('id' => 1, 'tag' => 'cool', 'language' => 'eng'),
				1 => array('id' => 2, 'tag' => 'beautiful', 'language' => 'eng'),
			)
        );
        $result = $this->Play->find('first', $query);
		//debug($result);
        $this->assertEqual($expected, $result);
		
		
		
		$expected = array(
            'Play' => array('id' => 2, 'author_id' => 1, 'language' => 'ukr', 'title' => 'Король Лір', 'year' => 1605),
			'Author' => array(
				'name' => 'Shakespeare', 'id' => 1, 'nacionality' => 'Англійська', 'language' => 'ukr',
			),
			'Scenario' => array('id' => 2, 'number_of_objects' => 120, 'concept' => 'Сучасна', 'language' => 'ukr'),
			'Tag' => array(
				0 => array('id' => 1, 'tag' => 'прохолодно', 'language' => 'ukr'),
				1 => array('id' => 2, 'tag' => 'красивий', 'language' => 'ukr'),
			)
        );
		
		$this->Play->setLanguage('ukr');
		$result = $this->Play->find('first', $query);
		//debug($result);
		$this->assertEqual($expected, $result);
		//die;
		
		
		
		 $query = array(
            'fields' => array('Play.title', 'Author.name', 'Author.nacionality', 'Scenario.number_of_objects', 'Scenario.concept'),
            'conditions' => array('Play.id' => 4),
			'contain' => array('Tag' => array('fields' => array('tag')))
        );
		
		$expected = array(
            'Play' => array('id' => 4, 'author_id' => 2, 'language' => 'ukr', 'title' => 'Трагедія Юлій Цезар', 'year' => 1599),
			'Author' => array(
				'name' => 'Italo Calvino', 'id' => 2, 'nacionality' => 'Італійський', 'language' => 'ukr',
			),
			'Scenario' => array('id' => 4, 'number_of_objects' => 2, 'concept' => 'Постмодерн', 'language' => 'ukr'),
			'Tag' => array(
				0 => array('id' => 1, 'tag' => 'прохолодно', 'language' => 'ukr'),
				1 => array('id' => 4, 'tag' => 'нечуваний', 'language' => 'ukr'),
			)
        );
		
		$this->Play->setLanguage('ukr');
		$result = $this->Play->find('first', $query);
		//debug($result);
		//die;
		$this->assertEqual($expected, $result);
    }
	
	function testSaveASimpleRecord()
    {
        $this->Play->setLanguage('eng');
        $data = array('Play' => array('title' => 'Antony and Cleopatra', 'author_id' => '1', 'year' => 1997, 'opening_excerpt' => 'This is a simple stupid test, lol.'));
        $this->Play->save($data);
		$expected = array('Play' => array(
			'id' => 6,
			'author_id' => 1,
			'title' => 'Antony and Cleopatra',
			'year' => 1997, 
			'opening_excerpt' => 'This is a simple stupid test, lol.',
			'language' => 'eng'
		));
		$result = $this->Play->find('first', array('conditions' => array('Play.id' => 6), 'fields' => array('Play.title', 'Play.opening_excerpt')));
		//debug($result);
		$this->assertEqual($expected, $result);
		
		
		$this->Play->setLanguage('ger');
        $data = array('Play' => array('id' => 6, 'title' => 'Antonius und Kleopatra', 'opening_excerpt' => 'Dies ist ein einfacher Test dumm, lol.'));
        $this->Play->save($data);
		$expected = array('Play' => array(
			'id' => 6,
			'author_id' => 1,
			'title' => 'Antonius und Kleopatra',
			'year' => 1997, 
			'opening_excerpt' => 'Dies ist ein einfacher Test dumm, lol.',
			'language' => 'ger'
		));
		$result = $this->Play->find('first', array('conditions' => array('Play.id' => 6), 'fields' => array('Play.title', 'Play.opening_excerpt')));
		$this->assertEqual($expected, $result);
		
		
		
		$this->Play->setLanguage('ger');
        $data = array('Play' => array('id' => 6, 'title' => 'Antoniuss und Kleopatra', 'opening_excerpt' => 'Dies ist ein einfacher Test dumm, lol.'));
        $this->Play->save($data);
		$expected = array('Play' => array(
			'id' => 6,
			'author_id' => 1,
			'title' => 'Antoniuss und Kleopatra',
			'year' => 1997, 
			'opening_excerpt' => 'Dies ist ein einfacher Test dumm, lol.',
			'language' => 'ger'
		));
		$result = $this->Play->find('first', array('conditions' => array('Play.id' => 6), 'fields' => array('Play.title', 'Play.opening_excerpt')));
		$this->assertEqual($expected, $result);
		
    }
	
	
	function testSaveAMultipleRecord()
    {
        $this->Play->setLanguage('eng');
		
        $data = array('Play' => array(
			0 => array('title' => 'Antony and Cleopatra', 'author_id' => 1, 'year' => 2005, 'opening_excerpt' => 'This is a second simple stupid test, lol.'),
			1 => array('title' => 'Me and You', 'author_id' => 2, 'year' => 2000, 'language' => 'ukr', 'opening_excerpt' => 'I wanna a beer.')
		));
		//debug($data);

        $this->Play->saveAll($data['Play']);
		$expected = array('Play' => array(
			'id' => 6,
			'author_id' => 1,
			'title' => 'Antony and Cleopatra',
			'year' => 2005, 
			'opening_excerpt' => 'This is a second simple stupid test, lol.',
			'language' => 'eng'
		));
		$result = $this->Play->find('first', array('conditions' => array('Play.id' => 6), 'fields' => array('Play.title', 'Play.opening_excerpt')));
		$this->assertEqual($expected, $result);
		
		$this->Play->setLanguage('ukr');
		$expected = array('Play' => array(
			'id' => 7,
			'author_id' => 2,
			'title' => 'Me and You',
			'year' => 2000, 
			'opening_excerpt' => 'I wanna a beer.',
			'language' => 'ukr'
		));
		$result = $this->Play->find('first', array('conditions' => array('Play.id' => 7), 'fields' => array('Play.title', 'Play.opening_excerpt')));
		$this->assertEqual($expected, $result);
		
    }
	
	function testACascadeSave()
    {
        $this->Play->setLanguage('eng');
		
        $data = array(
			'Play' => array(
				'title' => 'Antony and Cleopatra', 
				'opening_excerpt' => 'This is a simple stupid test, lol.',
				'year' => 2011
			),
			'Author' => array(
				'name' => 'New Author',
				'nacionality' => 'Brasilian'
			)
		);
		//debug($data);

        $this->Play->saveAll($data);
		$expected = array(
			'Play' => array(
				'id' => 6,
				'author_id' => 3,
				'title' => 'Antony and Cleopatra',
				'year' => 2011, 
				'opening_excerpt' => 'This is a simple stupid test, lol.',
				'language' => 'eng'
			),
			'Author' => array(
				'id' => 3,
				'name' => 'New Author',
				'nacionality' => 'Brasilian',
				'language' => 'eng'
			)
		);
		$result = $this->Play->find('first', array('conditions' => array('Play.id' => 6), 'fields' => array('Play.title', 'Play.opening_excerpt', 'Author.name', 'Author.nacionality')));
		$this->assertEqual($expected, $result);
		//die;
    }
	
	
	
	function testADeeperCascadeSave()
    {
        $this->Play->setLanguage('eng');
		
        $data = array(
			'Author' => array(
				'name' => 'New Author',
				'nacionality' => 'Brasilian',
			),
			'Image'	=> array(
				0 => array(
					'file' => 'blabla.bmp'
				),
				1 => array(
					'file' => 'teste.bmp'
				)
			)
		);
		//debug($data);

        $this->Author->saveAll($data);
		
		//$this->assertEqual(true, true);
		
		
		$expected = array(
			'Author' => array(
				'id' => 3,
				'name' => 'New Author',
				'nacionality' => 'Brasilian',
				'language' => 'eng'
			),
			'Image' => array(
				0 => array('author_id' => 3, 'file' => 'blabla.bmp'),
				1 => array('author_id' => 3, 'file' => 'teste.bmp')
			)
		);
		$result = $this->Author->find('first', array(
			'conditions' => array('Author.id' => 3), 'fields' => array('nacionality'), 'contain' => array(
				'Image' => array('fields' => array('file'))
			)
		));
		//debug($result);
		$this->assertEqual($expected, $result);
	
    }
	
}

?>
