<?php

$textos = array('sobre_dinafon' => array('Texto um pouco mais prolongado, de 400 a 1200 caracteres sobre o grupo de pesquisa.',
'Os diat. Ro dipsum quamet vel dolorper ing ex ex eu feum do commy nostrud min esto odo dit wis nim velit iure venibh eriure min ea atumsan hent dionsent wis adit la feu facil utat laor si bla augue eliqui bla commy numsan ut ut nonse duis estin ullumsandre magna commodo lortio consequip ex ex el ex ecte magna faccums andionum zzrit ut lute veliqui psustrud et illumsan essenit dit at.',
'Gueros at, sequisi. Dolobor aci te commolendre dip et, sim et la cons nisciduiscin utat, sequat ad tio consequis ad magniamet la consed modigni smodolum do commodo cor il utpatio odio consequamet aliquatue vel ut pratie vullandrem quam, quipsus tismodo lorpercing ent nonsequip eros et wis er sisissit la facin velisci euguer sisim iriure modit amconse quipis nim at. To consectet, si etue ming et lutat. Ut wisi.'),
'sobre_dinafon_pequeno' => 'Tradução para o português do seguinte texto:
Dinafon (from Portuguese Dinâmica Fônica, speech dynamics) is a Brazilian research group working on various aspects of language structure, acquisition, and use in light of Articulatory (or Gestural) Phonology. Topics of interest include dialectal variation, historical change, segment-prosody interaction, phonological acquisition and loss, speech in singing and acting. Languages of interest span the entire Brazilian territory as well as neighboring countries.',
'texto_contato' => array('Texto breve, de 50 a 200 caracteres direcionando as pessoas que desejam entrar em contato com o Dinafon.'),
'contatos' => array('telefones' => '+55 19 35211532',
'endereco' => 'LAFAPE, IEL/UNICAMP
Rua Sérgio Buarque de Holanda, 571
Cidade Universitária
Campinas/SP – Brazil
CEP 13.083–859',
'email' => 'albano@unicamp.br'),
'rodape' => 'Tradução para o português de:
""Dinafon stands for Dinâmica Fônica, speech dynamics, and names a group of phonologists/phoneticians led by Eleonora Albano.""',);

Configure::write('BDtemp.textos', $textos);

$config['precisa'] = 'disto'; // não remover esta linha

?>

<?php
/*
$textos = array(
	'sobre_dinafon' => array(
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'Este deve ser um texto assim, assim e assado, por isto não
		podemos desperdiçar tempo com coisas bestas e fúteis!',
		'askjdkj asdklkja askdlkjlkjasd lkjlkjalksjdlk ljasd lkjlkjlkajsd lkjlkjasd
		lkaçlkçlaksd çllaçlkslk aksljhouiu nya0u 394lkj l i lihas87 ohkjahskjnhanbxkiu6 rksb
		haksfhk shi utoustoiu ytln,lmn zhf slkj ho oahi kjshgoiuw k j,hg uj jkshj kh iuykj fgiuyate
		sjkhdsfgjkh soijs khzlk jsuoi enj,kmnlu ofgjhfgkjdhstuoy nfg9 jglkjhdsgdsa lj hdsgl hjsfg
		kj hkj shdlkfjlksdjf lkijslkdjfk lksjflkj slkfdjlkjlksjdf lksfliuipsjflknlksdfj  pisufljsdf
		lkjsdlfkj oisjlodjif ojsdlfklkjsfdloju oiusd flkjnmsoijlk  pjdfji dsfokjçljsdfpo  lojsdfij pos
		sdlkfjlksjdf lksdjflksjdfl lksdflksdj slkjdflk slkjsdflkj sdljlkjslkdj lksjdf lkj srou ulknfi ywt',
		'askjdkj asdklkja askdlkjlkjasd lkjlkjalksjdlk ljasd lkjlkjlkajsd lkjlkjasd
		lkaçlkçlaksd çllaçlkslk aksljhouiu nya0u 394lkj l i lihas87 ohkjahskjnhanbxkiu6 rksb
		haksfhk shi utoustoiu ytln,lmn zhf slkj ho oahi kjshgoiuw k j,hg uj jkshj kh iuykj fgiuyate
		sjkhdsfgjkh soijs khzlk jsuoi enj,kmnlu ofgjhfgkjdhstuoy nfg9 jglkjhdsgdsa lj hdsgl hjsfg
		kj hkj shdlkfjlksdjf lkijslkdjfk lksjflkj slkfdjlkjlksjdf lksfliuipsjflknlksdfj  pisufljsdf
		lkjsdlfkj oisjlodjif ojsdlfklkjsfdloju oiusd flkjnmsoijlk  pjdfji dsfokjçljsdfpo  lojsdfij pos
		sdlkfjlksjdf lksdjflksjdfl lksdflksdj slkjdflk slkjsdflkj sdljlkjslkdj lksjdf lkj srou ulknfi ywt'
	),
	'texto_contato' => array(
		'askjdkj asdklkja askdlkjlkjasd lkjlkjalksjdlk ljasd lkjlkjlkajsd lkjlkjasd
		lkaçlkçlaksd çllaçlkslk aksljhouiu nya0u 394lkj l i lihas87 ohkjahskjnhanbxkiu6 rksb
		haksfhk shi utoustoiu ytln,lmn zhf slkj ho oahi kjshgoiuw k j,hg uj jkshj kh iuykj fgiuyate
		sjkhdsfgjkh soijs khzlk jsuoi enj,kmnlu ofgjhfgkjdhstuoy nfg9 jglkjhdsgdsa lj hdsgl hjsfg
		kj hkj shdlkfjlksdjf lkijslkdjfk lksjflkj slkfdjlkjlksjdf lksfliuipsjflknlksdfj  pisufljsdf
		lkjsdlfkj oisjlodjif ojsdlfklkjsfdloju oiusd flkjnmsoijlk  pjdfji dsfokjçljsdfpo  lojsdfij pos
		sdlkfjlksjdf lksdjflksjdfl lksdflksdj slkjdflk slkjsdflkj sdljlkjslkdj lksjdf lkj srou ulknfi ywt',
		'kj hkj shdlkfjlksdjf lkijslkdjfk lksjflkj slkfdjlkjlksjdf lksfliuipsjflknlksdfj  pisufljsdf
		lkjsdlfkj oisjlodjif ojsdlfklkjsfdloju oiusd flkjnmsoijlk  pjdfji dsfokjçljsdfpo  lojsdfij pos
		sdlkfjlksjdf lksdjflksjdfl lksdflksdj slkjdflk slkjsdflkj sdljlkjslkdj lksjdf lkj srou ulknfi ywt'
	),
	'contatos' => array(
		'email' => 'spsassd@iel.unicamp.br',
		'endereco' => 'Rua Sérgio Buarque de Holanda, nº 441',
		'telefones' => '(19) 2121.4532',
	),
	'sobre_dinafon_pequeno' => 'Tradução do seguinte texto: <br/> <b>Dinafon</b> (from Portuguese <i><b>Di</b>nâmica <b>Fôn</b>ica</i>, speech dynamics) is a Brazilian research group working on various aspects of language structure, acquisition, and use in light of <i><b>Articulatory (or Gestural) Phonology</b></i>. Topics of interest include dialectal variation, historical change, segment-prosody interaction, phonological acquisition and loss, speech in singing and acting. Languages of interest span the entire Brazilian territory as well as neighboring countries.'
);

Configure::write('BDtemp.textos', $textos);

$config['precisa'] = 'disto'; // não remover esta linha
*/
?>