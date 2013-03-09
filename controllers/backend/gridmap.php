<?php

class Gridmap_Backend_Gridmap_Controller extends Admin_Controller {
    
    public function __construct()
    {
        parent::__construct();

        $this->data['bar'] = array(
            'title'       => Lang::line('gridmap::lang.Grid Map')->get(ADM_LANG),
            'url'         => URL::base() .DS.ADM_URI.'/grid_map',
            'description' => Lang::line('gridmap::lang.Allows administrators to update settings for the grid map')->get(ADM_LANG),
            'buttons'     => array(),
        );

        $this->data['section_bar'] = array(
            Lang::line('gridmap::lang.Settings')->get(ADM_LANG)    => URL::base().'/'.ADM_URI.'/grid_map',
        );
    }

    public function get_index()
    {
        $this->data['section_bar_active'] = Lang::line('gridmap::lang.Settings')->get(ADM_LANG);
        
        $this->data['settings'] = Settings\Model\Setting::where_module_slug('gridmap')->order_by('order', 'asc')->get();

        // Get all sections from settings
        $sections = array();
        foreach($this->data['settings'] as $setting) 
        {
            if(isset($setting->section) and !empty($setting->section))
            {
                if(!isset($sections[$setting->section]))
                {
                    $sections[$setting->section] = $setting->section;
                }
            }
        }
        $this->data['sections'] = $sections;

        //return $this->theme->render('splashscreen::backend.splashscreen.index', $this->data);

        return $this->theme->render('gridmap::backend.index', $this->data);
    }

    public function put_update()
    {
        $post_data = Input::get('order');
        
        if(isset($post_data) and !empty($post_data))
        {
            $order_items = explode(',', $post_data);
            foreach ($order_items as $order_position => $slug)
            {
                $affected = Settings\Model\Setting::where_slug($slug)
                               ->update(array('order' => $order_position));
            }
            return;
        }

        $settings = Input::all();

        $validation_rules = array();

        $db_settings = Settings\Model\Setting::where_in('slug', array_keys($settings))->get();

        foreach ($db_settings as $setting) 
        {
            if(!empty($setting->validation))
            {
                $validation_rules[$setting->slug] = $setting->validation;
            }
        }

        $validation = Validator::make($settings, $validation_rules)->speaks(ADM_LANG);

        if($validation->passes())
        {
            foreach ($settings as $slug => $value)
            {
                // Update runtime configurations.
                $setting = Config::get('settings::core.'.$slug);
                if($setting != null)
                {
                    Config::set('settings::core.'.$slug, $value);
                }
                // Update database configurations
                $affected = Settings\Model\Setting::where_slug($slug)
                                                    ->update(array('value' => $value));
            }
            $this->data['message'] = Lang::line('gridmap::lang.Settings were successfully updated')->get(ADM_LANG);
            $this->data['message_type'] = 'success';

            // redirect back to the module 
            return Redirect::back()->with($this->data);
        }
        else
        {
            return Redirect::back()->with($this->data)->with_errors($validation->errors);
        }
    }
}