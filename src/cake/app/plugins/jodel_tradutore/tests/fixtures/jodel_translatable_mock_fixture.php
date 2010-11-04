<?php

class JodelTranslatableMockFixture extends CakeTestFixture {

    var $name = 'JodelTranslatableMock';

    var $fields = array(
        'id' => array(
            'type' => 'integer',
            'key' => 'primary',
            'null' => false
        ),
        'title' => array(
            'type' => 'string',
            'length' => 80,
            'default' => '',
            'null' => false
        ),
        'year' => array(
            'type' => 'integer',
            'length' => 4,
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
        array('id' => 1, 'title' => 'Antony and Cleopatra', 'year' => 1606, 'opening_excerpt' => "Phil: Nay, but this dotage of our general's..."),
        array('id' => 2, 'title' => 'King Lear', 'year' => 1605, 'opening_excerpt' => "Earl of Kent: I thought the King had more affected the Duke of Albany than Cornwall."),
        array('id' => 3, 'title' => 'The Comedy of Errors', 'year' => 1589, 'opening_excerpt' => "Aegeon: Proceed, Solinus, to procure my fall\nAnd by the doom of death end woes and all."),
        array('id' => 4, 'title' => 'The Tragedy of Julius Caesar', 'year' => 1599, 'opening_excerpt' => "Flavius: Hence! home, you idle creatures get you home:\nIs this a holiday?"),
        array('id' => 5, 'title' => 'The Tragedy of Hamlet, Prince of Denmark', 'year' => 1600, 'opening_excerpt' => "Bernardo: Who's there?")
    );

}

?>
