<?php
class TextTextCork extends TextCorkAppModel
{
	var $actsAs = array('Corktile.CorkAttachable' => array('type' => 'text_cork'));
	/** saveCorkContent
	 *
	 *  This function is demanded by the Corktile contract. Basically, it must
	 *  insert the data in a table row. If an 'id' is given in the content, it
	 *  should update the data.
	 *
	 *  @param Array $content The data that must be saved. If empty it should be filled with
	 *                        the default content.
	 *  @param Array $options Special options related to this type of Cork. In the
	 *						  case of the TextCork this data can be:
	 *						    - 'maxLenght' => maximum lenght of chars it must have 
	 *							- 'minLenght' => minimum lenght of chars it should have
	 *                          - 'textile' => if set to true it should
	 *  @param boolean $fromForm It should be set from true, if the data sent is being
	 *							 sent directly from the Form.
	 *  @return The saved data ID on success. False on failure.
	 */ 
	function saveCorkContent($content = array(), $options = array(), $fromForm = false)
	{
		if (empty($content)) // sets the default content.
		{
			$content['TextTextCork']['text'] = __("TextTextCork Model: This text hasn't been written yet. It's up to the site content editor to write it.", true);
		}
		// @todo Treat the validation options, in order for it to work properly.
		if ($this->save($content))
			return $this->id;
		else
			return false;
	}

	/** getCorkContent
	 *
	 *  This function is demanded by the Corktile contract. Basically, it must
	 *  return the Model data for a given id.
	 *
	 *  @param $id The id of the row to be retrieved
	 *  @param Array $options If it should be variations on the regular behavior,
	 *                        these options should be passed to this array.
	 *                        In the special case of the text_cork there aren't
	 *  @return The data ID on success. False on failure.
	 */ 
	
	function getCorkContent($id, $options = array())
	{
		//@todo Make the right find.
		return $this->findById($id);	
	}
	
	/** 
	 *  This function is an optional function of the Burocrata contract. It will be 
	 *  called by a form of the type ('cork').
	 *
	 *  @param $data The data to be saved.
	 *  @return The same as save's.
	 */ 
	
	function saveBurocrataCork($data)
	{
		//@todo Include validation rules here!
		return $this->save($data);
	}
}

?>
