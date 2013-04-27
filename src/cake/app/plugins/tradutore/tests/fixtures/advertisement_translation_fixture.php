<?php

/**
 *
 * Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2013, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 * @author     Bruno Franciscon Mazzotti <mazzotti@preface.com.br>
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

class AdvertisementTranslationFixture extends CakeTestFixture
{
    var $name = 'AdvertisementTranslation';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'advertisement_id' => array(
            'type' => 'integer',
            'null' => false
        ),
		// Conforming ISO-639-1 language codes.
        'language' => array(
            'type' => 'string',
            'length' => 10,
            'default' => 'eng',
            'null' => false
        ),
        'advertisement' => array(
            'type' => 'text',
            'null' => false
        )
    );
    
    var $records = array(
        array(
            // English
            'id' => 1,
            'advertisement_id' => 1,
            'language' => 'eng',
            'advertisement' => "Antony and Cleopatra is a tragedy by William Shakespeare, believed to have been written sometime between 1603 and 1607. It was first printed in the First Folio of 1623. The plot is based on Thomas North's translation of Plutarch's Life of Marcus Antonius and follows the relationship between Cleopatra and Mark Antony from the time of the Parthian War to Cleopatra's suicide. The major antagonist is Octavius Caesar, one of Antony's fellow triumviri and the future first emperor of Rome. The tragedy is a Roman play characterized by swift, panoramic shifts in geographical locations and in registers, alternating between sensual, imaginative Alexandria and the more pragmatic, austere Rome."
        ),
		array(
            // Ukrainian
            'id' => 2,
            'advertisement_id' => 1,
            'language' => 'ukr',
            'advertisement' => "Антоній і Клеопатра трагедії Вільяма Шекспіра, як вважають, була написана десь між 1603 і 1607. Вперше вона була надрукована в Першому фоліо в 1623 році. Сюжет заснований на переклад Томаса Півночі життя Плутарха Марка Антонія і слід зв'язок між Клеопатри і Марка Антонія з моменту парфянської війни до самогубства Клеопатри. Основні антагоніст Цезар Цезар, один з товаришів triumviri Антонія та майбутнього першого імператора Риму. Трагедія в тому, грати римські характеризується швидким, панорамний зрушення в географічних точках і в регістрах, чергуючи чуттєвий, творчі Олександрії і більш прагматичними, суворий Римі."
        ),
        array(
            // English
            'id' => 3,
            'advertisement_id' => 2,
            'language' => 'eng',
            'advertisement' => "Mark Antony – one of the Triumvirs of Rome along with Octavian and Marcus Aemilius Lepidus – has neglected his soldierly duties after being beguiled by Egypt's Queen, Cleopatra VII. He ignores Rome's domestic problems, including the fact that his third wife Fulvia rebelled against Octavian and then died."
        ),
		array(
            // Ukrainian
            'id' => 4,
            'advertisement_id' => 2,
            'language' => 'ukr',
            'advertisement' => "Марк Антоній - один з тріумвірів до Рима разом з Октавіан і Марк Емілій Лепід - знехтував своєї солдатської обов'язків після того, як обдурив королева Єгипту, Клеопатри VII. Він ігнорує Риму внутрішні проблеми, в тому числі тим, що його третя дружина Фульвія повстали проти Октавіана, а потім помер."
        ),
		array(
            // English
            'id' => 5,
            'advertisement_id' => 3,
            'language' => 'eng',
            'advertisement' => "King Lear is a tragedy by William Shakespeare, considered to be one of his greatest dramatic masterpieces. The title character descends into madness after foolishly disposing of his estate between two of his three daughters based on their flattery, bringing tragic consequences for all. The play is based on the legend of Leir of Britain, a mythological pre-Roman Celtic king. It has been widely adapted for the stage and motion pictures, and the role of Lear has been coveted and played by many of the world's most accomplished actors."
        ),
		array(
            // Ukrainian
            'id' => 6,
            'advertisement_id' => 3,
            'language' => 'ukr',
            'advertisement' => "Король Лір трагедії Вільяма Шекспіра, вважається одним з його найбільших драматичних шедеврів. Назва символу спускається в безумство після нерозумно утилізації свій маєток між двома з трьох його дочок на основі їх лестощами, приносячи трагічні наслідки для всіх. П'єса заснована на легенді про Лір Великобританії, міфологічні доримского кельтський король. Він був широко адаптований для сцени і кіно, а роль Ліра була бажаною і грають багато з найвідоміших акторів світу."
        ),
		array(
            // English
            'id' => 7,
            'advertisement_id' => 4,
            'language' => 'eng',
            'advertisement' => "King Lear, who is elderly, wants to retire from power. He decides to divide his realm among his three daughters, and offers the largest share to the one who loves him best. Goneril and Regan both proclaim in fulsome terms that they love him more than anything in the world, which pleases him. For Cordelia, there is nothing to compare her love to, nor words to properly express it; she speaks honestly; but bluntly which infuriates him. In his anger he disinherits her, and divides the kingdom between Regan and Goneril. Kent objects to this unfair treatment. Lear is further enraged by Kent's protests, and banishes him from the country. Cordelia's two suitors enter. Learning that Cordelia has been disinherited, the Duke of Burgundy withdraws his suit, but the King of France is impressed by her honesty and marries her."
        ),
		array(
            // Ukrainian
            'id' => 8,
            'advertisement_id' => 4,
            'language' => 'ukr',
            'advertisement' => "Король Лір, який знаходиться в похилому віці, хоче відійти від влади. Він вирішує розділити своє царство серед своїх трьох дочок, і пропонує найбільшу частку до того, хто любить його кращим. Гонерілья і Регана і проголосити в груба умови, що вони люблять його більше, ніж що-небудь у світі, який йому подобається. Для Корделія, немає нічого, щоб порівняти її із задоволенням, ні слова, щоб правильно висловити це, вона говорить щиро, але прямо яка дратує його. У гніві він disinherits її, і ділить королівство між Регана і Гонерілья. Кент заперечує проти цього несправедливого поводження. Лір далі лють протести Кента, і виганяє його з країни. Корделії двох наречених увійти. Дізнавшись, що Корделія була знедолених, герцога Бургундського відкликає свій позов, але король Франції вражений її чесності і одружується з нею."
        ),
		array(
            // English
            'id' => 9,
            'advertisement_id' => 5,
            'language' => 'eng',
            'advertisement' => "The Comedy of Errors is one of William Shakespeare's earliest plays, believed to have been written between 1592 and 1594. It is his shortest and one of his most farcical comedies, with a major part of the humour coming from slapstick and mistaken identity, in addition to puns and word play. The Comedy of Errors (along with The Tempest) is one of only two of Shakespeare's plays to observe the classical unities. It has been adapted for opera, stage, screen and musical theatre."
        ),
		array(
            // Ukrainian
            'id' => 10,
            'advertisement_id' => 5,
            'language' => 'ukr',
            'advertisement' => "Комедія помилок є одним з найбільш ранніх грає Вільяма Шекспіра, як вважають, була написана між 1592 і 1594. Це його коротким і одним з його найбільш фарсових комедій, з більшої частини гумору Виходячи з фарсу і помилкової ідентифікації, на додаток до каламбури і гра слів. Комедія помилок (разом з Буре) є однією з усього лише двох з п'єси Шекспіра дотримуватися класичні одиниць. Вона була адаптована до опери, сцена, екран і музичний театр."
        ),
		array(
            // English
            'id' => 11,
            'advertisement_id' => 6,
            'language' => 'eng',
            'advertisement' => "The Comedy of Errors tells the story of two sets of identical twins that were accidentally separated at birth. Antipholus of Syracuse and his servant, Dromio of Syracuse, arrive in Ephesus, which turns out to be the home of their twin brothers, Antipholus of Ephesus and his servant, Dromio of Ephesus. When the Syracusans encounter the friends and families of their twins, a series of wild mishaps based on mistaken identities lead to wrongful beatings, a near-seduction, the arrest of Antipholus of Ephesus, and accusations of infidelity, theft, madness, and demonic possession."
        ),
		array(
            // Ukrainian
            'id' => 12,
            'advertisement_id' => 6,
            'language' => 'ukr',
            'advertisement' => "Комедія помилок розповідає історію двох наборів ідентичних близнюків, які були випадково розділені при народженні. Antipholus Сіракуз і його слуга, Dromio Сіракуз, прибули в Ефес, яка виявляється будинку своїх братів-близнюків, Antipholus Ефеський та його слуга, Dromio Ефеса. Коли сіракузян зустріч друзів і сім'ї їх близнюки, ряд диких невдач на основі помилковою тотожності призвести до протиправних побиття, майже зваблювання, арешт Antipholus з Ефеса, і звинувачення в зраді, крадіжки, безумство і одержимість демонами ."
        ),
		array(
            // English
            'id' => 13,
            'advertisement_id' => 7,
            'language' => 'eng',
            'advertisement' => "Due to a law forbidding the presence of Syracusian merchants in Ephesus, elderly Syracusian trader Egeon faces execution when he is discovered in the city. He can only escape by paying a fine of a thousand marks. He tells his sad story to the Duke. In his youth, he married and had twin sons. On the same day, a poor woman also gave birth to twin boys, and he purchased these as slaves to his sons. Soon afterwards, the family made a sea voyage, and was hit by a tempest. Egeon lashed himself to the main-mast with one son and one slave, while his wife was rescued by one boat, Egeon by another. Egeon never again saw his wife, or the children with her. Recently, his son Antipholus of Syracuse, now grown, and his son’s slave Dromio of Syracuse, left Syracuse on a quest to find their brothers. When Antipholus of Syracuse did not return, Egeon set out in search of him."
        ),
		array(
            // Ukrainian
            'id' => 14,
            'advertisement_id' => 7,
            'language' => 'ukr',
            'advertisement' => "Через закон, що забороняє присутність Syracusian купців в Ефесі, літні Syracusian трейдер Egeon особи виконання, коли він виявив у місті. Він може тільки піти, заплативши штраф у тисячу марок. Він розповідає свою сумну історію з герцогом. У юності, він одружений і мав синів-близнюків. У той же день, бідна жінка також народила близнюків, і він купив їх як рабів на своїх синів. Незабаром після цього сім'я зробила подорож по морю, і потрапив під бурю. Egeon шмагав себе грот-щогла, має сина і одного раба, а його дружина була врятована від одному човні, Egeon іншим. Egeon ніколи не бачив свою дружину, чи дітей з собою. Останнім часом його син Antipholus Сіракузи, зараз виріс, і раба свого сина Dromio Сіракузи, ліворуч Сиракузи на пошуки, щоб знайти своїх братів. Коли Antipholus Сіракузи не повернувся, Egeon вирушили на пошуки його."
        ),
		array(
            // English
            'id' => 15,
            'advertisement_id' => 8,
            'language' => 'eng',
            'advertisement' => "The Tragedy of Julius Caesar is a tragedy by William Shakespeare, believed to have been written in 1599.[1] It portrays the 44 BC conspiracy against the Roman dictator Julius Caesar, his assassination and the defeat of the conspirators at the Battle of Philippi. It is one of several Roman plays that Shakespeare wrote, based on true events from Roman history, which also include Coriolanus and Antony and Cleopatra."
        ),
		array(
            // Ukrainian
            'id' => 16,
            'advertisement_id' => 8,
            'language' => 'ukr',
            'advertisement' => "Трагедія Юлій Цезар трагедії Вільяма Шекспіра, як вважають, була написана в 1599 році [1]. Він зображує 44 р. до н.е. змові проти диктатора римський Юлій Цезар, його вбивство і поразка змовників у битві при Филипах. Це один з декількох римських прослуховування, що Шекспір писав, заснована на реальних подіях з історії Римської, які також включають Коріолан і Антоній і Клеопатра."
        ),	
    );
}

?>
