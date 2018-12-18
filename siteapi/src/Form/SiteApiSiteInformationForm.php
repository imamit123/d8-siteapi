<?php

namespace Drupal\siteapi\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\system\Form\SiteInformationForm;

/**
 * Configure site information settings.
 */

class SiteApiSiteInformationForm extends SiteInformationForm {
	public function buildForm(array $form, FormStateInterface $form_state) {
    // Get system.site configuration value.
		$site_config = $this->config('system.site');
		// Get the original form from the class.
		$form = parent::buildForm($form, $form_state);
		// Add a textfield to the site information section.
		$form['site_information']['siteapi'] = [
		  '#type' => 'textfield',
		  '#title' => t('Site API'),
		  '#default_value' => $site_config->get('siteapikey') ? $site_config->get('siteapikey') : '',
		  '#description' => $this->t('The site API key of the site'),
		];
		if($site_config->get('siteapikey')){
	  	$form['actions']['submit']['#value'] = t('Update Configuration');
  	}
		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		$this->config('system.site')
			->set('siteapikey', $form_state->getValue('siteapi'))
			->save();
		parent::submitForm($form, $form_state);
	}
}
