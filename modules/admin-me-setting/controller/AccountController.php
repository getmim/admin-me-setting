<?php
/**
 * AccountController
 * @package admin-me-setting
 * @version 0.0.1
 */

namespace AdminMeSetting\Controller;

use LibForm\Library\Form;
use LibUser\Library\Fetcher;

class AccountController extends \AdminMeSetting\Controller
{
    public function passwordAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);

        $form = new Form('admin.me.setting.password');
        $params = [
            '_meta' => [
                'title' => 'Change Password'
            ],
            'form'  => $form,
            'success' => false
        ];

        if(!($valid = $form->validate($this->user)) || !$form->csrfTest('noob'))
            return $this->resp('me/setting/password', $params);

        $errors = [];

        // make sure the password is valid
        if(!$this->user->verifyPassword($valid->{'old-password'}, $this->user))
            $errors[] = ['old-password', '0.0', 'Wrong password'];

        if($valid->{'new-password'} != $valid->{'retype-password'})
            $errors[] = ['retype-password', '0.0', 'The password is different'];

        if($errors){
            foreach($errors as $error)
                $form->addError($error[0], $error[1], $error[2]);
            return $this->resp('me/setting/password', $params);
        }

        $new_password = $this->user->hashPassword($valid->{'new-password'});

        $user_set = ['password'=>$new_password];
        Fetcher::set($user_set, ['id'=>$this->user->id]);

        $this->addLog([
            'user'   => $this->user->id,
            'object' => $this->user->id,
            'parent' => 0,
            'method' => 2,
            'type'   => 'user',
            'original' => (object)['password'=>$this->user->password],
            'changes'  => (object)$user_set
        ]);

        $params['success'] = true;
        return $this->resp('me/setting/password', $params);
    }

    public function profileAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);

        $form = new Form('admin.me.setting.profile');

        $params = [
            '_meta' => [
                'title' => 'Profile'
            ],
            'form'  => $form,
            'success' => false
        ];

        $fields = (array)$form->getFields();
        $grouped_fields = group_by_prop($fields, 'xpos');
        $params['fields'] = [];
        foreach($grouped_fields as $group => &$fields){
            usort($fields, function($a,$b){ return $a->xindex - $b->xindex; });
            $params['fields'][$group] = array_column($fields, 'name');
        }

        if(!($valid = $form->validate($this->user)) || !$form->csrfTest('noob'))
            return $this->resp('me/setting/profile', $params);

        if(!Fetcher::set((array)$valid, ['id'=>$this->user->id]))
            return $this->show500((object)['text'=>Fetcher::lastError()]);

        $oobj = (object)[];
        foreach($valid as $key => $val)
            $oobj->$key = $this->user->$key;
        
        $this->addLog([
            'user'   => $this->user->id,
            'object' => $this->user->id,
            'parent' => 0,
            'method' => 2,
            'type'   => 'user',
            'original' => $oobj,
            'changes'  => $valid
        ]);

        $params['success'] = true;
        return $this->resp('me/setting/profile', $params);
    }
}