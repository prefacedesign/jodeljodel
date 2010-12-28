<?php
class PersPerson extends PersonAppModel {
	var $name = 'PersPerson';
	var $validate = array(
		'auth_author_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'img_image_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	var $actsAs = array('Dashboard.DashDashboardable', 'Status.Status' => array('publishing_status'));
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/*var $belongsTo = array(
		'AuthAuthor' => array(
			'className' => 'AuthAuthor',
			'foreignKey' => 'auth_author_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ImgImage' => array(
			'className' => 'ImgImage',
			'foreignKey' => 'img_image_id',
			'conditions' => '',
			'fields' => '',
			'order' => '' 
		)
	);*/
		
		/* Creates a blank row in the table. It is part of the backstage contract.
         *
		 */
        function createEmpty()
        {
			//@todo Maybe the status behavior should place these defaults?
			//Or should it be a global default?
			$data = $this->save(array('publishing_status' => 'draft'));
            $data[$this->name]['id'] = $this->id;
            
            return $data;
        }
        
		/* Find suited for the burocrata form. Part of the Burocrata/Backstage contract.
         *
		 */
		
        function findBurocrata($id)
        {
            return $this->findById($id);
        }
		
		/** Find suited for 
		 *
		 */
		
		function getDashboardInfo($id)
		{
			$data = $this->findById($id);
			
			if ($data == null)
				return null;
			
			$dashdata = array(
				'dashable_id' => $data['PersPerson']['id'],
				'dashable_model' => $this->name,
				'type' => 'Person',
				'status' => $data['PersPerson']['publishing_status'],
				'created' => $data['PersPerson']['created'],
				'modified' => $data['PersPerson']['modified'], 
				'name' => $data['PersPerson']['name'] . ' ' . $data['PersPerson']['surname'],
				'info' => 'Profile: ' . substr($data['PersPerson']['profile'],0, 20) . '...',
				'idiom' => 'PT'
			);
			
			return $dashdata;
		}
}
?>