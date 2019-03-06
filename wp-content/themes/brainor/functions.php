<?php
/**
 * Функции шаблона (function.php)
 * @package WordPress
 * @subpackage brainor
 */

add_theme_support('title-tag'); // теперь тайтл управляется самим вп


register_nav_menus(array( // Регистрируем 2 меню
	'top' => 'Верхнее', // Верхнее
	'bottom' => 'Внизу' // Внизу
));

add_theme_support('post-thumbnails'); // включаем поддержку миниатюр
set_post_thumbnail_size(250, 150); // задаем размер миниатюрам 250x150
add_image_size('big-thumb', 400, 400, true); // добавляем еще один размер картинкам 400x400 с обрезкой

register_sidebar(array( // регистрируем левую колонку, этот кусок можно повторять для добавления новых областей для виджитов
	'name' => 'Сайдбар', // Название в админке
	'id' => "sidebar", // идентификатор для вызова в шаблонах
	'description' => 'Обычная колонка в сайдбаре', // Описалово в админке
	'before_widget' => '<div id="%1$s" class="widget %2$s">', // разметка до вывода каждого виджета
	'after_widget' => "</div>\n", // разметка после вывода каждого виджета
	'before_title' => '<span class="widgettitle">', //  разметка до вывода заголовка виджета
	'after_title' => "</span>\n", //  разметка после вывода заголовка виджета
));

if (!class_exists('clean_comments_constructor')) { // если класс уже есть в дочерней теме - нам не надо его определять
	class clean_comments_constructor extends Walker_Comment { // класс, который собирает всю структуру комментов
		public function start_lvl( &$output, $depth = 0, $args = array()) { // что выводим перед дочерними комментариями
			$output .= '<ul class="children">' . "\n";
		}
		public function end_lvl( &$output, $depth = 0, $args = array()) { // что выводим после дочерних комментариев
			$output .= "</ul><!-- .children -->\n";
		}
	    protected function comment( $comment, $depth, $args ) { // разметка каждого комментария, без закрывающего </li>!
	    	$classes = implode(' ', get_comment_class()).($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : ''); // берем стандартные классы комментария и если коммент пренадлежит автору поста добавляем класс author-comment
	        echo '<li id="comment-'.get_comment_ID().'" class="'.$classes.' media">'."\n"; // родительский тэг комментария с классами выше и уникальным якорным id
	    	echo '<div class="media-left">'.get_avatar($comment, 64, '', get_comment_author(), array('class' => 'media-object'))."</div>\n"; // покажем аватар с размером 64х64
	    	echo '<div class="media-body">';
	    	echo '<span class="meta media-heading">Автор: '.get_comment_author()."\n"; // имя автора коммента
	    	//echo ' '.get_comment_author_email(); // email автора коммента, плохой тон выводить почту
	    	echo ' '.get_comment_author_url(); // url автора коммента
	    	echo ' Добавлено '.get_comment_date('F j, Y в H:i')."\n"; // дата и время комментирования
	    	if ( '0' == $comment->comment_approved ) echo '<br><em class="comment-awaiting-moderation">Ваш комментарий будет опубликован после проверки модератором.</em>'."\n"; // если комментарий должен пройти проверку
	    	echo "</span>";
	        comment_text()."\n"; // текст коммента
	        $reply_link_args = array( // опции ссылки "ответить"
	        	'depth' => $depth, // текущая вложенность
	        	'reply_text' => 'Ответить', // текст
				'login_text' => 'Вы должны быть залогинены' // текст если юзер должен залогинеться
	        );
	        echo get_comment_reply_link(array_merge($args, $reply_link_args)); // выводим ссылку ответить
	        echo '</div>'."\n"; // закрываем див
	    }
	    public function end_el( &$output, $comment, $depth = 0, $args = array() ) { // конец каждого коммента
			$output .= "</li><!-- #comment-## -->\n";
		}
	}
}

if (!function_exists('pagination')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function pagination() { // функция вывода пагинации
		global $wp_query; // текущая выборка должна быть глобальной
		$big = 999999999; // число для замены
		$links = paginate_links(array( // вывод пагинации с опциями ниже
			'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
			'format' => '?paged=%#%', // формат, %#% будет заменено
			'current' => max(1, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
			'type' => 'array', // нам надо получить массив
			'prev_text'    => 'Назад', // текст назад
	    	'next_text'    => 'Вперед', // текст вперед
			'total' => $wp_query->max_num_pages, // общие кол-во страниц в пагинации
			'show_all'     => false, // не показывать ссылки на все страницы, иначе end_size и mid_size будут проигнорированны
			'end_size'     => 15, //  сколько страниц показать в начале и конце списка (12 ... 4 ... 89)
			'mid_size'     => 15, // сколько страниц показать вокруг текущей страницы (... 123 5 678 ...).
			'add_args'     => false, // массив GET параметров для добавления в ссылку страницы
			'add_fragment' => '',	// строка для добавления в конец ссылки на страницу
			'before_page_number' => '', // строка перед цифрой
			'after_page_number' => '' // строка после цифры
		));
	 	if( is_array( $links ) ) { // если пагинация есть
		    echo '<ul class="pagination">';
		    foreach ( $links as $link ) {
		    	if ( strpos( $link, 'current' ) !== false ) echo "<li class='active'>$link</li>"; // если это активная страница
		        else echo "<li>$link</li>"; 
		    }
		   	echo '</ul>';
		 }
	}
}

add_action('wp_footer', 'add_scripts'); // приклеем ф-ю на добавление скриптов в футер
if (!function_exists('add_scripts')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function add_scripts() { // добавление скриптов
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    wp_deregister_script('jquery'); // выключаем стандартный jquery
	    wp_enqueue_script('jquery','//code.jquery.com/jquery-3.2.1.slim.min.js','','',true); // добавляем свой
	    wp_enqueue_script('popper','//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js','','',true); // popper
	    wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap/bootstrap.min.js','','',true); // бутстрап
	    wp_enqueue_script('jq-no-conflict', get_template_directory_uri().'/js/jq-no-conflict.js','','',true); // jq-no-confilct
	    wp_enqueue_script('of-canvas', get_template_directory_uri().'/addons/Off-Canvas-Menu-Bootstrap-4/dist/js/slidebars.min.js','','',true); // off-canvas
	    wp_enqueue_script('of-canvas-component', get_template_directory_uri().'/addons/Off-Canvas-Menu-Bootstrap-4/dist/js/component-slidebars.min.js','','',true); // off-canvas-component
	    wp_enqueue_script('formstyle', get_template_directory_uri().'/addons/jQueryFormStyler/jquery.formstyler.min.js','','',true); // formstyle
	    wp_enqueue_script('owl', get_template_directory_uri().'/addons/OwlCarousel/dist/owl.carousel.min.js','','',true); // owl
	    wp_enqueue_script('fancyBox', get_template_directory_uri().'/addons/fancybox/dist/jquery.fancybox.min.js','','',true); // fancybox
	    wp_enqueue_script('ymap', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&coordorder=longlat','','',false); // ymap
	    wp_enqueue_script('main', get_template_directory_uri().'/js/main.js','','',true); // и скрипты шаблона
	}
}

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function add_styles() { // добавление стилей
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    wp_enqueue_style( 'bs', get_template_directory_uri().'/css/bootstrap/bootstrap.min.css' ); // бутстрап
	    wp_enqueue_style( 'formstyle', get_template_directory_uri().'/addons/jQueryFormStyler/jquery.formstyler.css' ); // formstyle
	    wp_enqueue_style( 'off-canvas', get_template_directory_uri().'/addons/Off-Canvas-Menu-Bootstrap-4/dist/css/component-slidebars.min.css' ); // Off-Canvas
	    wp_enqueue_style( 'fa', get_template_directory_uri().'/addons/fa/css/all.css' ); // fa
	    wp_enqueue_style( 'owl', get_template_directory_uri().'/addons/OwlCarousel/dist/assets/owl.carousel.min.css' ); // owl
	    wp_enqueue_style( 'owl-theme', get_template_directory_uri().'/addons/OwlCarousel/dist/assets/owl.theme.default.min.css' ); // owl
	    wp_enqueue_style( 'fancyBox', get_template_directory_uri().'/addons/fancybox/dist/jquery.fancybox.min.css' ); // fancybox
		wp_enqueue_style( 'main', get_template_directory_uri().'/css/general.css' ); // основные стили шаблона
		wp_enqueue_style( 'products', get_template_directory_uri().'/css/sidebar-products.css' ); // товары
	}
}

if (!class_exists('bootstrap_menu')) {
	class bootstrap_menu extends Walker_Nav_Menu { // внутри вывод 
		private $open_submenu_on_hover; // параметр который будет определять раскрывать субменю при наведении или оставить по клику как в стандартном бутстрапе

		function __construct($open_submenu_on_hover = true) { // в конструкторе
	        $this->open_submenu_on_hover = $open_submenu_on_hover; // запишем параметр раскрывания субменю
	    }

		function start_lvl(&$output, $depth = 0, $args = array()) { // старт вывода подменюшек
			$output .= "\n<ul class=\"dropdown-menu\">\n"; // ул с классом
		}
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) { // старт вывода элементов
			$item_html = ''; // то что будет добавлять
			parent::start_el($item_html, $item, $depth, $args); // вызываем стандартный метод родителя
			if ( $item->is_dropdown && $depth === 0 ) { // если элемент содержит подменю и это элемент первого уровня
			   if (!$this->open_submenu_on_hover) $item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"', $item_html); // если подменю не будет раскрывать при наведении надо добавить стандартные атрибуты бутстрапа для раскрытия по клику
			   $item_html = str_replace('</a>', ' <b class="caret"></b></a>', $item_html); // ну это стрелочка вниз
			}
			$output .= $item_html; // приклеиваем теперь
		}
		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) { // вывод элемента
			if ( $element->current ) $element->classes[] = 'active'; // если элемент активный надо добавить бутстрап класс для подсветки
			$element->is_dropdown = !empty( $children_elements[$element->ID] ); // если у элемента подменю
			if ( $element->is_dropdown ) { // если да
			    if ( $depth === 0 ) { // если li содержит субменю 1 уровня
			        $element->classes[] = 'dropdown'; // то добавим этот класс
			        if ($this->open_submenu_on_hover) $element->classes[] = 'show-on-hover'; // если нужно показывать субменю по хуверу
			    } elseif ( $depth === 1 ) { // если li содержит субменю 2 уровня
			        $element->classes[] = 'dropdown-submenu'; // то добавим этот класс, стандартный бутстрап не поддерживает подменю больше 2 уровня по этому эту ситуацию надо будет разрешать отдельно
			    }
			}
			parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); // вызываем стандартный метод родителя
		}
	}
}

if (!function_exists('content_class_by_sidebar')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function content_class_by_sidebar() { // функция для вывода класса в зависимости от существования виджетов в сайдбаре
		if (is_active_sidebar( 'sidebar' )) { // если есть
			echo 'col-sm-9'; // пишем класс на 80% ширины
		} else { // если нет
			echo 'col-sm-12'; // контент на всю ширину
		}
	}
}

/**
 * Like get_template_part() put lets you pass args to the template file
 * Args are available in the template as $template_args array
 * @param string filepart
 * @param mixed wp_args style argument list
 */
function hm_get_template_part( $file, $template_args = array(), $cache_args = array() ) {
    $template_args = wp_parse_args( $template_args );
    $cache_args = wp_parse_args( $cache_args );
    if ( $cache_args ) {
        foreach ( $template_args as $key => $value ) {
            if ( is_scalar( $value ) || is_array( $value ) ) {
                $cache_args[$key] = $value;
            } else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
                $cache_args[$key] = call_user_method( 'get_id', $value );
            }
        }
        if ( ( $cache = wp_cache_get( $file, serialize( $cache_args ) ) ) !== false ) {
            if ( ! empty( $template_args['return'] ) )
                return $cache;
            echo $cache;
            return;
        }
    }
    $file_handle = $file;
    do_action( 'start_operation', 'hm_template_part::' . $file_handle );
    if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) )
        $file = get_stylesheet_directory() . '/' . $file . '.php';
    elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
        $file = get_template_directory() . '/' . $file . '.php';
    ob_start();
    $return = require( $file );
    $data = ob_get_clean();
    do_action( 'end_operation', 'hm_template_part::' . $file_handle );
    if ( $cache_args ) {
        wp_cache_set( $file, $data, serialize( $cache_args ), 3600 );
    }
    if ( ! empty( $template_args['return'] ) )
        if ( $return === false )
            return false;
        else
            return $data;
    echo $data;
}

/**
 * Обновление блока корзины
 */
function get_cart_update(){
    echo '(' . WC()->cart->get_cart_contents_count() . ' на ' . WC()->cart->get_cart_total() . ')';
    wp_die();
}
add_action( 'wp_ajax_get_cart_update', 'get_cart_update' );
add_action( 'wp_ajax_nopriv_get_cart_update', 'get_cart_update' );

add_action('admin_menu', 'add_gcf_interface');

function add_gcf_interface() {
    add_options_page('Настройка полей', 'Настройка полей', '8', 'functions', 'editglobalcustomfields');
}

function editglobalcustomfields() {
    ?>
	<div class='wrap'>
		<h2>Настройки полей</h2>
		<form method="post" action="options.php">
            <?php wp_nonce_field('update-options') ?>

			<p>
				<strong>Телефон:</strong><br/>
				<input type="text" name="phone" size="45" value="<?php echo get_option('phone'); ?>" />
			</p>

			<p>
				<strong>Instagram:</strong><br/>
				<input type="text" name="instagram" size="45" value="<?php echo get_option('instagram'); ?>" />
			</p>

			<p>
				<strong>Карта:</strong><br/>
				<textarea name="map" cols="50" rows="10"><?php echo get_option('map'); ?></textarea>
			</p>

			<p>
				<strong>Трансляция:</strong><br/>
				<textarea name="live" cols="50" rows="10"><?php echo get_option('live'); ?></textarea>
			</p>

			<p><input type="submit" name="Submit" value="Сохранить" /></p>

			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="phone,instagram,map,live" />

		</form>
	</div>
    <?php
}

/**
 * Add Bootstrap form styling to WooCommerce fields
 *
 * @since  1.0
 * @refer  http://bit.ly/2zWFMiq
 */
function iap_wc_bootstrap_form_field_args ($args, $key, $value) {

    $args['input_class'][] = 'form-control';
    return $args;
}
add_filter('woocommerce_form_field_args','iap_wc_bootstrap_form_field_args', 10, 3);

if ( ! function_exists( 'woocommerce_form_field' ) ) {

    /**
     * Outputs a checkout/address form field.
     *
     * @param string $key Key.
     * @param mixed  $args Arguments.
     * @param string $value (default: null).
     * @return string
     */
    function woocommerce_form_field( $key, $args, $value = null ) {
        $defaults = array(
            'type'              => 'text',
            'label'             => '',
            'description'       => '',
            'placeholder'       => '',
            'maxlength'         => false,
            'required'          => false,
            'autocomplete'      => false,
            'id'                => $key,
            'class'             => array(),
            'label_class'       => array(),
            'input_class'       => array('form-control'),
            'return'            => false,
            'options'           => array(),
            'custom_attributes' => array(),
            'validate'          => array(),
            'default'           => '',
            'autofocus'         => '',
            'priority'          => '',
        );

        $args = wp_parse_args( $args, $defaults );
        $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

        if ( $args['required'] ) {
            $args['class'][] = 'validate-required';
            $required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
        } else {
//            $required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
            $required = '';
        }

        if ( is_string( $args['label_class'] ) ) {
            $args['label_class'] = array( $args['label_class'] );
        }

        if ( is_null( $value ) ) {
            $value = $args['default'];
        }

        // Custom attribute handling.
        $custom_attributes         = array();
        $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

        if ( $args['maxlength'] ) {
            $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
        }

        if ( ! empty( $args['autocomplete'] ) ) {
            $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
        }

        if ( true === $args['autofocus'] ) {
            $args['custom_attributes']['autofocus'] = 'autofocus';
        }

        if ( $args['description'] ) {
            $args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
        }

        if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
            foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
                $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
            }
        }

        if ( ! empty( $args['validate'] ) ) {
            foreach ( $args['validate'] as $validate ) {
                $args['class'][] = 'validate-' . $validate;
            }
        }

        $field           = '';
        $label_id        = $args['id'];
        $sort            = $args['priority'] ? $args['priority'] : '';
//        $field_container = '<div class="form-group form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div>';
        $field_container = '<div class="form-group" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</div>';

        switch ( $args['type'] ) {
            case 'country':
                $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

                if ( 1 === count( $countries ) ) {

                    $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

                    $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';

                } else {

                    $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="">' . esc_html__( 'Select a country&hellip;', 'woocommerce' ) . '</option>';

                    foreach ( $countries as $ckey => $cvalue ) {
                        $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                    }

                    $field .= '</select>';

                    $field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '">' . esc_html__( 'Update country', 'woocommerce' ) . '</button></noscript>';

                }

                break;
            case 'state':
                /* Get country this state field is representing */
                $for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
                $states      = WC()->countries->get_states( $for_country );

                if ( is_array( $states ) && empty( $states ) ) {

//                    $field_container = '<div class="form-group form-row %1$s" id="%2$s" style="display: none">%3$s</div>';
                    $field_container = '<div class="form-group" id="%2$s" style="display: none">%3$s</div>';

                    $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" />';

                } elseif ( ! is_null( $for_country ) && is_array( $states ) ) {

                    $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
						<option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';

                    foreach ( $states as $ckey => $cvalue ) {
                        $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                    }

                    $field .= '</select>';

                } else {

                    $field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

                }

                break;
            case 'textarea':
                $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

                break;
            case 'checkbox':
                $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
						<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

                break;
            case 'text':
            case 'password':
            case 'datetime':
            case 'datetime-local':
            case 'date':
            case 'month':
            case 'time':
            case 'week':
            case 'number':
            case 'email':
            case 'url':
            case 'tel':
                $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

                break;
            case 'select':
                $field   = '';
                $options = '';

                if ( ! empty( $args['options'] ) ) {
                    foreach ( $args['options'] as $option_key => $option_text ) {
                        if ( '' === $option_key ) {
                            // If we have a blank option, select2 needs a placeholder.
                            if ( empty( $args['placeholder'] ) ) {
                                $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                            }
                            $custom_attributes[] = 'data-allow_clear="true"';
                        }
                        $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
                    }

                    $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
							' . $options . '
						</select>';
                }

                break;
            case 'radio':
                $label_id = current( array_keys( $args['options'] ) );

                if ( ! empty( $args['options'] ) ) {
                    foreach ( $args['options'] as $option_key => $option_text ) {
                        $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
                        $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
                    }
                }

                break;
        }

        if ( ! empty( $field ) ) {
            $field_html = '';

            if ( $args['label'] && 'checkbox' !== $args['type'] ) {
                $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
            }

            $field_html .= '<span class="woocommerce-input-wrapper">' . $field;

            if ( $args['description'] ) {
                $field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
            }

            $field_html .= '</span>';

            $container_class = esc_attr( implode( ' ', $args['class'] ) );
            $container_id    = esc_attr( $args['id'] ) . '_field';
            $field           = sprintf( $field_container, $container_class, $container_id, $field_html );
        }

        /**
         * Filter by type.
         */
        $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

        /**
         * General filter on form fields.
         *
         * @since 3.4.0
         */
        $field = apply_filters( 'woocommerce_form_field', $field, $key, $args, $value );

        if ( $args['return'] ) {
            return $field;
        } else {
            echo $field; // WPCS: XSS ok.
        }
    }
}

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = 999;
    return $cols;
}
//Убираем оповещалки в корзине
add_filter( 'wc_add_to_cart_message_html', '__return_null' );

//КОНЕЦ  Убираем оповещалки в корзине
?>
