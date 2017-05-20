<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MIAInstaller\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        //$this->permissionsZetaController();
        //$this->gadgets();
        //$this->history();
        /*$columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\Integer('Zeta Controller', 'controller_id'),
            new \MIAInstaller\Generate\Field\Integer('User', 'user_id'),
            new \MIAInstaller\Generate\Field\CreatedAt(),
            new \MIAInstaller\Generate\Field\UpdatedAt()
        );
        $entity = new \MIAInstaller\Generate\Table();
        $entity->setName('Owner');
        $entity->setFolder('ZetaController');
        $entity->setModule('Application');
        $entity->setColumns($columns);
        $entity->run();*/
        
        //$this->cloneRepository();
        //$this->createApi();
        
        return new ViewModel();
    }
    
    protected function createApi()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\StringF('Title', 'title'),
            new \MIAInstaller\Generate\Field\Text('Caption', 'caption'),
            new \MIAInstaller\Generate\Field\StringF('Address', 'address'),
            new \MIAInstaller\Generate\Field\Integer('Latitude', 'latitude'),
            new \MIAInstaller\Generate\Field\Integer('Longitude', 'longitude'),
            new \MIAInstaller\Generate\Field\Integer('Ranking', 'ranking'),
            new \MIAInstaller\Generate\Field\CreatedAt()
        );
        
        /*$controller = new \MIAInstaller\Generate\Crud();
        $controller->setName('Disco');
        $controller->setModule('Application');
        $controller->setColumns($columns);
        $controller->run();*/
        
        /*$android = new \MIAInstaller\Generate\Android\Realm();
        $android->setPackage('com.mobileia.theparty');
        $android->setName('Disco');
        $android->setColumns($columns);
        $android->setRepository('https://matiascamiletti:123qwegit@bitbucket.org/matiascamiletti/the-party-android.git');
        $android->run();*/
        
        /*$android = new \MIAInstaller\Generate\Android\Adapter();
        $android->setPackage('com.mobileia.theparty');
        $android->setName('Disco');
        $android->setColumns($columns);
        $android->setRepository('https://matiascamiletti:123qwegit@bitbucket.org/matiascamiletti/the-party-android.git');
        $android->run();*/
        
        /*$android = new \MIAInstaller\Generate\Android\Fragment\ListRecycler();
        $android->setPackage('com.mobileia.theparty');
        $android->setName('Disco');
        $android->setColumns($columns);
        $android->setRepository('https://matiascamiletti:123qwegit@bitbucket.org/matiascamiletti/the-party-android.git');
        $android->run();*/
        
        /*$controller = new \MIAInstaller\Generate\Api\Controller();
        $controller->setName('Disco');
        $controller->setModule('Api');
        $controller->setColumns($columns);
        $controller->run();*/
    }
    
    public function cloneRepository()
    {
        try {
            // Clonar repositorio
            $repo = \Cz\Git\GitRepository::cloneRepository('https://matiascamiletti:123qwegit@bitbucket.org/matiascamiletti/the-party-android.git', './data/repositories/the-party-android');
        } catch (\Cz\Git\GitException $exc) {
            // Si ya existe abrimos el repositorio.
            $repo = new \Cz\Git\GitRepository('./data/repositories/the-party-android');
        }

        
        
    }
    
    public function permissionsZetaController()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\Integer('Controller', 'controller_id'),
            new \MIAInstaller\Generate\Field\Integer('User', 'user_id'),
            new \MIAInstaller\Generate\Field\StringF('Name', 'name'),
            new \MIAInstaller\Generate\Field\Integer('Delay', 'delay'),
            new \MIAInstaller\Generate\Field\Integer('Status', 'status'),
            new \MIAInstaller\Generate\Field\CreatedAt(),
            new \MIAInstaller\Generate\Field\UpdatedAt()
        );
        
        $controller = new \MIAInstaller\Generate\Crud();
        $controller->setName('AssignTrustee');
        $controller->setFolder('ZetaController');
        $controller->setModule('Application');
        $controller->setColumns($columns);
        $controller->run();
    }
    
    public function gadgets()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\Integer('Controller', 'controller_id'),
            new \MIAInstaller\Generate\Field\Integer('Code', 'code'),
            new \MIAInstaller\Generate\Field\StringF('Name', 'name'),
            new \MIAInstaller\Generate\Field\Integer('Delay', 'delay'),
            new \MIAInstaller\Generate\Field\Integer('Status', 'status'),
            new \MIAInstaller\Generate\Field\CreatedAt()
        );
        
        $controller = new \MIAInstaller\Generate\Crud();
        $controller->setName('Gadget');
        $controller->setFolder('ZetaController');
        $controller->setModule('Application');
        $controller->setColumns($columns);
        $controller->run();
        
        $android = new \MIAInstaller\Generate\Android\Realm();
        $android->setPackage('com.mobileia.zeta');
        $android->setName('Gadget');
        $android->setColumns($columns);
        $android->run();
    }
    
    public function history()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\Integer('Controller', 'controller_id'),
            new \MIAInstaller\Generate\Field\Integer('User', 'user_id'),
            new \MIAInstaller\Generate\Field\Integer('Status', 'status'),
            new \MIAInstaller\Generate\Field\CreatedAt()
        );
        
        $controller = new \MIAInstaller\Generate\Crud();
        $controller->setName('History');
        $controller->setFolder('ZetaController');
        $controller->setModule('Application');
        $controller->setColumns($columns);
        $controller->run();
        
        $android = new \MIAInstaller\Generate\Android\Realm();
        $android->setPackage('com.mobileia.zeta');
        $android->setName('ZetaControllerHistory');
        $android->setColumns($columns);
        $android->run();
    }
    
    public function request()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\Integer('User', 'user_id'),
            new \MIAInstaller\Generate\Field\StringF('Address', 'address'),
            new \MIAInstaller\Generate\Field\StringF('Phone', 'phone'),
            new \MIAInstaller\Generate\Field\Datetime('Visit date', 'date_visit'),
            new \MIAInstaller\Generate\Field\Integer('Amount', 'amount'),
            new \MIAInstaller\Generate\Field\Text('Data', 'data'),
            new \MIAInstaller\Generate\Field\CreatedAt(),
            new \MIAInstaller\Generate\Field\UpdatedAt()
        );
        
        $android = new \MIAInstaller\Generate\Android\Activity\Add();
        $android->setPackage('com.mobileia.zeta.activities');
        $android->setName('ZetaControllerRequestActivity');
        $android->setColumns($columns);
        $android->run();
        
        // Crear controlador
        $controller = new \MIAInstaller\Generate\Controller();
        $controller->setName('Request');
        $controller->setFolder('ZetaController');
        $controller->setModule('Application');
        $controller->setColumns($columns);
        $controller->run();
        
        $entity = new \MIAInstaller\Generate\Entity();
        $entity->setName('Request');
        $entity->setFolder('ZetaController');
        $entity->setModule('Application');
        $entity->setColumns($columns);
        $entity->run();
        
        $form = new \MIAInstaller\Generate\Form();
        $form->setName('Request');
        $form->setFolder('ZetaController');
        $form->setModule('Application');
        $form->setColumns($columns);
        $form->run();
        
        $table = new \MIAInstaller\Generate\Table();
        $table->setName('Request');
        $table->setFolder('ZetaController');
        $table->setModule('Application');
        $table->setColumns($columns);
        $table->run();
        
        echo 'llego'; exit();
    }
    
    public function zetaController()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Id(),
            new \MIAInstaller\Generate\Field\StringF('Code', 'code'),
            new \MIAInstaller\Generate\Field\Text('Token', 'token'),
            new \MIAInstaller\Generate\Field\Text('Caption', 'caption'),
            new \MIAInstaller\Generate\Field\StringF('ip', 'ip'),
            new \MIAInstaller\Generate\Field\Integer('Port', 'port'),
            new \MIAInstaller\Generate\Field\CreatedAt(),
            new \MIAInstaller\Generate\Field\UpdatedAt()
        );
        
        $controller = new \MIAInstaller\Generate\Crud();
        $controller->setName('ZetaController');
        $controller->setModule('Application');
        $controller->setColumns($columns);
        $controller->run();
    }
    
    public function test()
    {
        $columns = array(
            new \MIAInstaller\Generate\Field\Integer('ID', 'id'),
            new \MIAInstaller\Generate\Field\Integer('MIA ID', 'mia_id'),
            new \MIAInstaller\Generate\Field\StringF('Firstname', 'fistname'),
            new \MIAInstaller\Generate\Field\StringF('Lastname', 'lastname'),
            new \MIAInstaller\Generate\Field\Email('Email', 'email'),
            new \MIAInstaller\Generate\Field\Text('Photo', 'photo'),
            new \MIAInstaller\Generate\Field\StringF('Facebook ID', 'facebook_id'),
            new \MIAInstaller\Generate\Field\Datetime('Created at', 'created_at'),
            new \MIAInstaller\Generate\Field\Datetime('Updated at', 'updated_at')
        );
        
        $entity = new \MIAInstaller\Generate\Entity();
        $entity->setName('User2');
        $entity->setModule('MIAAuthentication');
        $entity->setColumns($columns);
        $entity->run();
    }
}
