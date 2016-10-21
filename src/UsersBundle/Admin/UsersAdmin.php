<?php
namespace UsersBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UsersAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper) {
        $user = $this->getSubject();

        $avatarFieldOptions = array('required' => false, 'data_class' => null);
        if ($user) {
            $avatar = $user->getAvatar();
            if (empty($avatar)) {
                $avatar = $user->getDefaultAvatar();
            } else {
                $avatar = $user->getDefaultAvatar();
            }

            // add a 'help' option containing the preview's img tag
            $avatarFieldOptions['help'] = '<img src="' . $avatar . '" class="admin-preview" />';
        }

        $formMapper
            ->with('General')
            ->add('username')
            ->add('email')
            ->end()
            ->with('Profile')
            ->add('avatar', 'file', $avatarFieldOptions)
            ->add(
                'firstname',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'lastname',
                'text',
                array(
                    'required' => false,
                )
            )
            ->add(
                'groups',
                'sonata_type_model',
                array(
                    'required'     => false,
                    'expanded'     => true,
                    'multiple'     => true,
                    'by_reference' => false
                )
            )
            ->end() ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username');
        //->add('actif');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('avatar', 'string', array('template' => 'UsersBundle::Admin/list_avatar.html.twig'))
            ->addIdentifier('email')
            ->add('username')
            ->add('name', 'string', array('template' => 'MongoboxUsersBundle::Admin/User/Fields/name.html.twig'))
            ->add('groups')
            ->add('lastLogin')
        ;
        //  ->add('actif');
    }

    public function getTemplate($name)
    {
        if (isset($this->templates[$name])) {
            return $this->templates[$name];
        }

        return null;
    }

}