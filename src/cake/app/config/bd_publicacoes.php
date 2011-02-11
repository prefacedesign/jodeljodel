<?php

$publicacoes = array(array(
'titulo' => 'Über die von der molekularkinetischen Theorie der Wärme geforderte Bewegung von in ruhenden Flüssigkeiten suspendierten Teilchen.',
'data' => '1905/05/01',
'palavras_chave' => array('atomismo','movimento browniano','física','fluidos','caminhada aleatória'),
'autores' => array('Einstein, Albert'),
'periodico' => 'Annalen der Physik',
'referencia' => 'Annalen der Physik 322 (8): 549–560. doi:10.1002/andp.19053220806.',
'arquivo' => '1905_17_549-560.pdf',
'resumo' => array('In dieser Arbeit soll gezeigt werden, daß nach der molekular-kinetischen Theorie der Wärme in Flüssigkeiten suspendierte Körper von mikroskopisch sichtbarer Größe infolge der Molekularbewegung der Wärme Bewegungen von solcher Größe aueführen müssen, daß diese Bewegungen leicht mit dem Mikroskop nachgewiesen werden können. Es ist möglich, daß die hier zu behandelnden Bewegungen mit der sogenannten „ßrownsehen .Molekularbewegung"" identisch sind; die mir erreichbaren Angaben über letztere sind jedoch so ungenau, daß ich mir hierüber kein Urteil bilden konnte.',
'Wenn sich die hier zu behandelnde Bewegung samt den für sie zu erwartenden Gesetzmäßigkeiten wirklich beobachten läßt, so ist die klassische Thermodynamik schon für mikroskopisch unterscbeidbare Räume nicht mehr als genau gültig anzusehen und es ist dann eine exakte Bestimmung der wahren Atomgröße möglich. Erwiese sich umgekehrt die Voraussage dieser Bewegung als unzutreffend, so wäre damit ein schwerwiegendes Argument gegen die molekularkinetische Auffassung der Wärme gegeben.')
),array(
'titulo' => 'Time, Structure, and Fluctuations ',
'data' => '1978/09/01',
'palavras_chave' => array('dinâmica','sistemas fora de eqüilíbrio','flutuações','termodinâmica'),
'autores' => array('Prigogine, Ilya'),
'periodico' => 'Science Magazine',
'referencia' => 'Science 1 September 1978: Vol. 201. no. 4358, pp. 777 - 785. DOI: 10.1126/science.201.4358.777',
'arquivo' => 'artigo.pdf',
'resumo' => array('Fundamental conceptual problems that arise from the macroscopic and microscopic aspects of the second law of thermodynamics are considered. It is shown that nonequilibrium may become a source of order and that irreversible processes may lead to a new type of dynamic states of matter called ""dissipative structures."" The thermodynamic theory of such structures is outlined. A microscopic definition of irreversible processes is given, and a transformation theory is developed that allows one to introduce nonunitary equations of motion that explicitly display irreversibility and approach to thermodynamic equilibrium. The work of the group at the University of Brussels in these fields is briefly reviewed. In this new development of theoretical chemistry and physics, it is likely that thermodynamic concepts will play an ever-increasing role.')
),array(
'titulo' => 'Stochastic dynamics and non-equilibrium thermodynamics of a bistable chemical system: the Schlögl model revisited',
'data' => '2008/12/18',
'palavras_chave' => array('sistemas duplamente estáveis','processos estocásticos','taxa de variação da entropia'),
'autores' => array('Quian, Hong','Vellela, Melissa'),
'periodico' => 'J. of the Royal Society',
'referencia' => 'J. R. Soc. Interface  6 October 2009   vol. 6  no. 39  925-940',
'arquivo' => 'artigo.pdf',
'resumo' => array('Schlögl\'s model is the canonical example of a chemical reaction system that exhibits bistability. Because the biological examples of bistability and switching behaviour are increasingly numerous, this paper presents an integrated deterministic, stochastic and thermodynamic analysis of the model. After a brief review of the deterministic and stochastic modelling frameworks, the concepts of chemical and mathematical detailed balances are discussed and non-equilibrium conditions are shown to be necessary for bistability. Thermodynamic quantities such as the flux, chemical potential and entropy production rate are defined and compared across the two models. In the bistable region, the stochastic model exhibits an exchange of the global stability between the two stable states under changes in the pump parameters and volume size. The stochastic entropy production rate shows a sharp transition that mirrors this exchange. A new hybrid model that includes continuous diffusion and discrete jumps is suggested to deal with the multiscale dynamics of the bistable system. Accurate approximations of the exponentially small eigenvalue associated with the time scale of this switching and the full time-dependent solution are calculated using Matlab. A breakdown of previously known asymptotic approximations on small volume scales is observed through comparison with these and Monte Carlo results. Finally, in the appendix section is an illustration of how the diffusion approximation of the chemical master equation can fail to represent correctly the mesoscopically interesting steady-state behaviour of the system.')
));

function compara_publicacoes($p1, $p2)
{
	if ($p1['data'] == $p2['data']) {
        return 0;
    }
    return ($p1 < $p2) ? -1 : 1;
}

usort($publicacoes, 'compara_publicacoes');

Configure::write('BDtemp.publicacoes', $publicacoes);

$config['precisa'] = 'disto'; // não remover esta linha

?>
