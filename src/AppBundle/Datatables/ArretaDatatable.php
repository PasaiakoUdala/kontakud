<?php

namespace AppBundle\Datatables;

use AppBundle\Entity\Barrutia;
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
                                 'classes'                       => Style::BOOTSTRAP_3_STYLE.' table-condensed',
                                 'individual_filtering'          => true,
                                 'individual_filtering_position' => 'head',
                                 'length_menu'                   => array( 10, 25, 50, 100 ),
                                 'order_cells_top'               => true,
                                 'order'                         => array( array( 1, 'desc' ) ),
                                 'dom'                           => 'Bfrtip',
                                 'page_length'                   => 50,
                             'paging_type'                      => Style::FULL_NUMBERS_PAGINATION,
                             ) );

        $this->features->set(
            array(
                'auto_width' => true,
                'info'       => true,
                'paging'     => true,
                'searching'  => true,
            )
        );

        $this->extensions->set(
            array(
                'responsive' => false,
                'buttons'    => false,
            )
        );

        $users = $this->em->getRepository( 'AppBundle:User' )->findAll();
        $kanalak = $this->em->getRepository( 'AppBundle:Kanala' )->findAll();
//        $barrutiak = $this->em->getRepository( 'AppBundle:Barrutia' )->findAll();

        $barrutiak = array();

        $b = new Barrutia();
        $b->setName( 'Donibane' );
        $barrutiak[] = $b;

        $b = new Barrutia();
        $b->setName( 'Trintxerpe' );
        $barrutiak[] = $b;

        $b = new Barrutia();
        $b->setName( 'Antxo' );
        $barrutiak[] = $b;

        $b = new Barrutia();
        $b->setName( 'San Pedro' );
        $barrutiak[] = $b;

        $b = new Barrutia();
        $b->setName( 'Beste batzuk / Otros' );
        $barrutiak[] = $b;

        $this->columnBuilder
            ->add(
                null,
                MultiselectColumn::class,
                array(
                    'start_html'   => '<div class="start_checkboxes">',
                    'end_html'     => '</div>',
                    'value'        => 'id',
                    'value_prefix' => true,
                    //'render_actions_to_id' => 'sidebar-multiselect-actions',
                    'actions'      => array(
                        array(
                            'route'           => 'arreta_bulk_delete',
                            'icon'            => 'glyphicon glyphicon-ok',
                            'label'           => $this->translator->trans( 'Ezabatu aukeratutako Arretak' ),
                            'attributes'      => array(
                                'rel'   => 'tooltip',
                                'title' => $this->translator->trans( 'Ezabatu aukeratutako Arretak' ),
                                'class' => 'btn btn-danger',
                                'role'  => 'button',
                            ),
                            'confirm'         => true,
                            'confirm_message' => $this->translator->trans( 'Ziur zaude?' ),
                            'start_html'      => '<div class="start_delete_action">',
                            'end_html'        => '</div>',
                        ),
                    ),
                )
            )
            ->add( 'id', Column::class, array(
                'title' => 'Id',
            ) )
            ->add( 'user.username', Column::class, array(
                'title'      => 'Langilea',
                'searchable' => true,
                'orderable'  => true,
                'filter'     => array( SelectFilter::class, array(
                    'select_options' => array( '' => 'All' ) + $this->getOptionsArrayFromEntities( $users, 'username', 'username' ),
                    'search_type'    => 'eq',
                ) ),
            ) )

            ->add( 'nan', Column::class, array(
                'title' => 'Nan',
            ) )
            ->add( 'barrutia', Column::class, array(
                'title'           => 'Arretaren barrutia',
                'default_content' => '',
                'searchable'      => true,
                'orderable'       => true,
                'filter'          => array( SelectFilter::class, array(
                    'select_options' => array( '' => 'All' ) + $this->getOptionsArrayFromEntities( $barrutiak, 'name', 'name' ),
                    'search_type'    => 'eq',
                ) ),
            ) )
            ->add( 'isclosed', BooleanColumn::class, array(
                'title'           => $this->translator->trans( 'Itxita' ),
                'searchable'      => true,
                'orderable'       => true,
                'true_label'      => 'Yes',
                'false_label'     => 'No',
                'default_content' => '',
                'true_icon'       => 'glyphicon glyphicon-ok',
                'false_icon'      => 'glyphicon glyphicon-remove',
                'filter'          => array( SelectFilter::class, array(
                    'classes'        => 'test1 test2',
                    'search_type'    => 'eq',
                    'multiple'       => false,
                    'select_options' => array(
                        ''  => 'Any',
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                    'cancel_button'  => true,
                ) ),
            ) )
            ->add( 'kanala.name', Column::class, array(
                'title'           => 'Kanala',
                'searchable'      => true,
                'orderable'       => true,
                'default_content' => '',
                'filter'          => array( SelectFilter::class, array(
                    'select_options' => array( '' => 'All' ) + $this->getOptionsArrayFromEntities( $kanalak, 'name', 'name' ),
                    'search_type'    => 'eq',
                ) ),
            ) )

            ->add( 'created', DateTimeColumn::class, array(
                'title'           => 'Data',
                'default_content' => '',
                'date_format'     => 'YYYY-MM-DD HH:mm:ss',
                'filter'          => array( DateRangeFilter::class, array(
                    'cancel_button' => true,
                ) ),
                'timeago'         => false,
            ) )

//            ->add( 'amaitu', DateTimeColumn::class, array(
//                'title'           => 'Amaitu',
//                'default_content' => '',
//                'date_format'     => 'YYYY-MM-DD HH:mm:ss',
//                'filter'          => array( DateRangeFilter::class, array(
//                    'cancel_button' => true,
//                ) ),
//                'timeago'         => false,
//            ) )

//            ->add( 'denbora', Column::class, array(
//                'title'      => 'denbora',
//                'dql'        => '(SELECT timediff({p}.amaitu,{p}.created) FROM AppBundle:Arreta {p} WHERE {p}.id = arreta.id)',
//                'searchable' => true,
//                'orderable'  => true,
//            ) )
            ->add( null, ActionColumn::class, array(
                'title'      => '',
                'start_html' => '<div class="start_actions btn-group" role="group">',
                'end_html'   => '</div>',
                'actions'    => array(
                    array(
                        'route'            => 'admin_arreta_edit',
                        'route_parameters' => array(
                            'id'      => 'id',
                            'type'    => 'testtype',
                            '_format' => 'html',
                            '_locale' => 'eu',
                        ),
                        'icon'             => 'glyphicon glyphicon-pencil',
                        'label'            => $this->translator->trans( 'Aldatu' ),
                        'attributes'       => array(
                            'rel'   => 'tooltip',
                            'title' => $this->translator->trans( 'Arretako xehetasunak aldatu' ),
                            'class' => 'btn btn-primary btn-xs',
                            'role'  => 'button',
                        ),
                    ),
                ),
            ) );
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
