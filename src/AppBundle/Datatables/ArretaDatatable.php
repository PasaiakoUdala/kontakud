<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Style;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\ImageColumn;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Editable\CombodateEditable;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextareaEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;

/**
 * Class ArretaDatatable
 *
 * @package AppBundle\Datatables
 */
class ArretaDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function buildDatatable( array $options = array() )
    {
        $this->language->set(
            array(
                'cdn_language_by_locale' => true,
            ) );

        $this->ajax->set( array() );

        $this->options->set( array(
                                 'classes'                       => Style::BOOTSTRAP_3_STYLE,
                                 'individual_filtering'          => true,
                                 'individual_filtering_position' => 'head',
                                 'length_menu' => array(10, 25, 50, 100),
                                 'order_cells_top'               => true,
                                 'order'                         => array( array( 0, 'asc' ) ),
                                 'dom'                           => 'Bfrtip',
                                 'page_length'                   => 50,
                             ) );

        $this->features->set( array() );

        $this->extensions->set(
            array(
                'responsive' => false,
                'buttons'    => false,
            )
        );

        $users = $this->em->getRepository( 'AppBundle:User' )->findAll();
        $kanalak = $this->em->getRepository( 'AppBundle:Kanala' )->findAll();
        $barrutiak = $this->em->getRepository( 'AppBundle:Barrutia' )->findAll();

        $this->columnBuilder
            ->add( 'id', Column::class, array(
                'title' => 'Id',
            ) )
            ->add( 'user.username', Column::class, array(
                'title' => 'Langilea',
                'searchable' => true,
                'orderable'  => true,
                'filter'     => array( SelectFilter::class, array(
                    'select_options' => array( '' => 'All' ) + $this->getOptionsArrayFromEntities( $users, 'username', 'username' ),
                    'search_type'    => 'eq',
                ) ),
            ) )
            ->add( 'created', DateTimeColumn::class, array(
                'title' => 'Fetxa',
                'default_content' => 'No value',
                'date_format' => 'L',
                'filter' => array(DateRangeFilter::class, array(
                    'cancel_button' => true,
                )),
                'timeago' => false
            ) )
            ->add( 'nan', Column::class, array(
                'title' => 'Nan',
            ) )
            ->add( 'barrutia', Column::class, array(
                'title' => 'Barrutia',
                'default_content' => '',
                'searchable' => true,
                'orderable'  => true,
                'filter'     => array( SelectFilter::class, array(
                    'select_options' => array( '' => 'All' ) + $this->getOptionsArrayFromEntities( $barrutiak, 'name', 'name' ),
                    'search_type'    => 'eq',
                ) ),
            ) )

            ->add('isclosed', BooleanColumn::class, array(
                'title' => 'Visible',
                'searchable' => true,
                'orderable' => true,
                'true_label' => 'Yes',
                'false_label' => 'No',
                'default_content' => '',
                'true_icon' => 'glyphicon glyphicon-ok',
                'false_icon' => 'glyphicon glyphicon-remove',
                'filter' => array(SelectFilter::class, array(
                    'classes' => 'test1 test2',
                    'search_type' => 'eq',
                    'multiple' => false,
                    'select_options' => array(
                        '' => 'Any',
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'cancel_button' => true,
                ))
            ))

            ->add( 'kanala.name', Column::class, array(
                'title' => 'Kanala',
                'searchable' => true,
                'orderable'  => true,
                'default_content' => '',
                'filter'     => array( SelectFilter::class, array(
                    'select_options' => array( '' => 'All' ) + $this->getOptionsArrayFromEntities( $kanalak, 'name', 'name' ),
                    'search_type'    => 'eq',
                ) ),
            ) )

            ->add(null, ActionColumn::class, array(
                'title' => '',
                'start_html' => '<div class="start_actions">',
                'end_html' => '</div>',
                'actions' => array(
                    array(
                        'route' => 'admin_arreta_edit',
                        'route_parameters' => array(
                            'id' => 'id',
                            'type' => 'testtype',
                            '_format' => 'html',
                            '_locale' => 'eu',
                        ),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'label' => 'Show Posting < a >',
                        'confirm' => true,
                        'confirm_message' => 'Are you sure?',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Show',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                    ),
//                    array(
//                        'icon' => 'glyphicon glyphicon-star',
//                        'label' => 'A < button >',
//                        'confirm' => false,
//                        'attributes' => array(
//                            'rel' => 'tooltip',
//                            'title' => 'Show',
//                            'class' => 'btn btn-primary btn-xs',
//                            'role' => 'button',
//                        ),
//                        'button' => true,
//                        'button_value' => 'id',
//                        'button_value_prefix' => true,
//                        'render_if' => function ($row) {
//                            return $this->authorizationChecker->isGranted('ROLE_ADMIN');
//                        },
//                        'start_html' => '<div class="start_show_action">',
//                        'end_html' => '</div>',
//                    ),
                ),
            ))

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Arreta';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'arreta_datatable';
    }
}
