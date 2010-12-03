<?php

switch ($type[0])
{
	case 'burocrata':
		if ($type[1] == 'form')
		{
                       echo $buro->input(array(),array(
                               'type' => 'hidden',
                               'fieldName' => 'id'
                       ));


                    echo $buro->sinput(
                        array(),
                        array(
                                'label' => __('Name',true),
                                'type' => 'super_field'
                        )
                    );



                       echo $buro->input(array(),array(
                               'type' => 'text',
                               'fieldName' => 'surname',
                               'label' => __('Family name',true),
                               'instructions' => __('Instructions for Family name',true)
                       ));

                       echo $buro->input(array(),array(
                               'type' => 'text',
                               'fieldName' => 'name',
                               'label' => __('First name',true),
                               'instructions' => __('Instructions for First name',true)
                       ));

                      echo $buro->input(array(),array(
                               'type' => 'text',
                               'fieldName' => 'reference_name',
                               'label' => __('Reference Name',true),
                               'instructions' => __('How you should be referenced',true)
                       ));

                     echo $buro->einput();



                       echo $buro->input(array(),array(
                               'type' => 'text',
                               'fieldName' => 'lattes_link',
                               'label' => __('Link for Lattes CV',true),
                               'instructions' => __('Instructions for Links for Lattes CV',true)
                       ));

                       echo $buro->input(array(),array(
                               'type' => 'textarea',
                               'fieldName' => 'research_fields',
                               'label' => __('Research Fields',true),
                               'instructions' => __('Instructions for Research Fields',true)
                       ));

                       echo $buro->input(array(),array(
                               'type' => 'textarea',
                               'fieldName' => 'profile',
                               'label' => __('Profile',true),
                               'instructions' => __('Instructions for Profile',true)
                       ));

                      echo $buro->input(array(),array(
                               'type' => 'textarea',
                               'fieldName' => 'cooperation_with_dinafon',
                               'label' => __('Cooperation with Dinafon',true),
                               'instructions' => __('Instructions for Cooperation With Dinafon',true)
                       ));

		}
	break;
}

?>