<?php

$noticias = array(array(
'titulo' => 'Encontro Tipográfico Nacional na ESAD',
'data' => '2010/06/02',
'autor' => 'Redação do Jornal de Caldas',
'texto' => array('A Escola Superior de Arte e Design (ESAD) das Caldas da Rainha promoveu no passado dia 28, no auditório 1, um encontro em torno do ensino da tipografia em Portugal.',
'Este encontro teve como objectivo de discutir o ensino da tipografia, e construir uma ligação com outros docentes em torno deste tema que apenas recentemente começa a ter uma presença no ensino do design e das artes gráficas.',
'Estiveram presentes os professores de várias escolas do ensino superior como Luís Moreira (Politécnico de Tomar), Jorge dos Reis (Faculdade de Belas Artes da Universidade de Lisboa), Paulo Silva (Instituto Superior de Arte e Design – IADE), Joana Lessa (Universidade do Algarve), Olinda Martins e Pedro Amado (Departamento de Comunicação da Universidade de Aveiro) e Paulo Ramalho, Aprígio Morgado, Ricardo Santos, Rúben Dias (ESAD).',
'Os intervenientes apresentaram os programas curriculares, métodos de trabalho e resultados dos projectos desenvolvidos pelos alunos permitindo um claro enriquecimento dos presentes. A discussão aberta permitiu, ainda, discutir métodos de trabalho e formas de melhorar o ensino da tipografia, tal como o sempre delicado assunto da pirataria de tipos de letra.',
'Por fim o evento originou um claro interesse em ligações mais próximas entre os docentes das várias escolas ficando mesmo em cima da mesa em tornar estes encontros regulares.',
'A ESAD realizou simultaneamente uma exposição com projectos das unidades curriculares de tipografia I II e III, mostrando assim resultados de uma forma ampla.')
),array(
'titulo' => 'Why did I start a type foundry?',
'data' => '2010/05/06',
'autor' => 'Christian Schwartz',
'texto' => array('Why would anyone in his or her right mind start a type foundry now? Well, to begin with, it’s often said that it’s a good idea to start a business in a recession. However, the type marketplace has gotten very crowded—there are more foundries and distributors of type in all sizes right now than at any previous time. Even the pre-machine setting peak of typefounding in the 19th century had a smaller number of foundries by many orders of magnitude. Notwithstanding all of the small foundries, a handful of large distributors dominate the general market, leaving the rest of us scrambling to find ever-shrinking niches. Why not just climb onboard with one of the big players and leave the business side to people who know what they’re doing? Would that be too easy?',
'It’s reassuring to know that we’re not the only ones with this crazy idea right now. There are a number of small new foundries that have just launched, or are about to launch, such as the Bureau des Affaires Typographiques in Paris and The Indian Type Foundry in the Netherlands and India.',
'My own particular story begins in 2002, when I released FF Bau with FontFont and got an email out of the blue from Paul Barnes, a designer in London, asking a very specific question about the lowercase g. I can’t find the original email, but it was something to the effect of “Where did you find your ‘g’? I’ve only seen the single story version in the historical sources I’ve seen. Did you make it up?” This was the beginning of a nerdy friendship that turned into a working relationship when Mark Porter, then the creative director at The Guardian, threw us together as a team for their 2005 redesign. This worked out well enough that we continued working together on custom typefaces for various clients, including the Empire State Building restoration, The New York Times style magazine T, and Condé Nast Portfolio, a business magazine that sadly became a casualty of the recession in 2009.',
'Without really being conscious of it it, several years had gone by and Paul and I were doing most of our projects as a team. What’s more the exclusivity on the Guardian family was soon going to expire and we had some decisions to make. To be honest, I don’t think we have another family like this in us. Designing Guardian, with its 6 components (some still not yet released) covering serif, sans, optical sizes, and even an agate in 4 grades, was a massive amount of work. This could be the foundation of a new foundry—a family that, if we were lucky, would sell well enough to allow us to indulge ourselves in some of our more bizarre ideas.',
'')
));

function compara_noticias($p1, $p2)
{
	if ($p1['data'] == $p2['data']) {
        return 0;
    }
    return ($p1 < $p2) ? -1 : 1;
}

usort($noticias, 'compara_noticias');

Configure::write('BDtemp.noticias', $noticias);

$config['precisa'] = 'disto'; // não remover esta linha

?>
