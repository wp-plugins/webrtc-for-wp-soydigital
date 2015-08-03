<?php 

/**

 * @package digital-rtc

 */

/*

Plugin Name: WebRTC para Wordpress de SoyDigital

Plugin URI: http://carlos-herrera.com

Description: Inserta facilmente tu codigo Digital-RTC de SoyDigital con este plugin,mediante widget o shotrcode

Version: 1.0

Author: Carlos Herrera

Author URI: http://carlos-herrera.com

License: GPLv2 or later

*/



/*

This program is free software; you can redistribute it and/or

modify it under the terms of the GNU General Public License

as published by the Free Software Foundation; either version 2

of the License, or (at your option) any later version.



This program is distributed in the hope that it will be useful,

but WITHOUT ANY WARRANTY; without even the implied warranty of

MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

GNU General Public License for more details.



You should have received a copy of the GNU General Public License

along with this program; if not, write to the Free Software

Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

// Creating the widget 

class digital_rtc extends WP_Widget {

	

	function __construct() 

	{

		parent::__construct(

		// Base ID of your widget

		'd_rtc', 

		// Widget name will appear in UI

		__('Digital-RTC Widget', 'd_rtc'),

		// Widget description

		array( 'description' => __( 'Easily add Digital-RTC code on your web', 'd_rtc' ), ) 

		);

	}



	// Creating widget front-end

	// This is where the action happens

	public function data_html_output()

	{

		$time=time();

		return( '<div id="web_rtc_'.$time.'"></div>

		<script type="text/javascript">

		var datas_'.$time.'=document.getElementById(\'web_rtc_'.$time.'\');

		embedWebRTCClient(datas_'.$time.');</script>');

		

	}

	

	public function widget( $args, $instance ) 

	{

		$title = apply_filters( 'widget_title', $instance['title'] );

		

		// before and after widget arguments are defined by themes

		echo $args['before_widget'];

		if ( ! empty( $title ) )

		echo $args['before_title'] . $title . $args['after_title'];



		// This is where you run the code and display the output

		echo digital_rtc::data_html_output();

		echo $args['after_widget'];

	}

		

	// Widget Backend 

	public function form( $instance ) 

	{

		if ( isset( $instance[ 'title' ] ) ) 

		{

			$title = $instance[ 'title' ];

		}

		else 

		{

			$title = __( 'Llamada Web-RTC', 'd_rtc' );

		}

		// Widget admin form

		?>

		<p>

		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 

		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		</p>

		<p><?php echo __('To set up you must go to Settings','d_rtc').' > <a href="options-general.php?page=digital_rtc">'.__('Set WebRTC for Wordpress SoyDigital','d_rtc').'</a>'; ?></p>

		<?php 

	}

	

	// Updating widget replacing old instances with new

	public function update( $new_instance, $old_instance ) 

	{

		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;

	}

	

} // Class wpb_widget ends here



function digital_rtc_options()

{

	

	add_option('digital_rtc_varkey','');
	add_option('digital_rtc_w','250');
	add_option('digital_rtc_h','200');
	add_option('digital_rtc_b','http://www.soydigital.com/images/webrtc-demo-iframe.png');

}

register_activation_hook(__FILE__,'digital_rtc_options');





 function admin_zone()

	{

		$url_soydigital="http://www.soydigital.com/plugin/webrtc-wp-form";
		$_REQUEST['d_rtc_submit']?$data='<div class="notice is-dismissible updated"><p>'.__('Saved Data','d_rtc').'</p></div>':false;
		$check1=get_option('digital_rtc_b')==plugins_url( '/assets/img/empresas.png', __FILE__ )?'checked':'';
		$check2=get_option('digital_rtc_b')==plugins_url( '/assets/img/personal.png', __FILE__ )?'checked':'';
		$check3=((get_option('digital_rtc_b')<>plugins_url( '/assets/img/empresas.png', __FILE__ ))&&(get_option('digital_rtc_b')<>plugins_url( '/assets/img/personal.png', __FILE__ )))?'checked':'';
		$data.='<div class="welcome-panel ch_chat">

					<div class="wrap">

						<h2>'.__('Set WebRTC for Wordpress SoyDigital','d_rtc').'</h2>

						<hr/>

						<form method="POST" action="?page=digital_rtc">

						<div class="welcome-panel-column-container">

							<div class="<!--welcome-panel-column-->">

								<h3 class="wp-menu-image dashicons-before dashicons-nametag"> '.__('SoyDigital Customer ID','d_rtc').'</h3>

								<p>'.__('You must register yourself in SoyDigital for a customer ID','d_rtc').' <a href="'.$url_soydigital.'" target="_blank">'.__('click here to register','d_rtc').'</a>.</p>

								<p><label>SoyDigital Var Key</label> <input type="text" name="digital_rtc_varkey" value="'.get_option('digital_rtc_varkey').'" /></p>
								<h3 class="wp-menu-image dashicons-before dashicons-phone"> '.__('Configure Widget','d_rtc').'</h3>
								<!--<p><label>Altura del Widget</label> <input type="text" name="digital_rtc_h" value="'.get_option('digital_rtc_h').'" />px</p>
								<p><label>Ancho del Widget</label> <input type="text" name="digital_rtc_w" value="'.get_option('digital_rtc_w').'" />px</p>-->
								
								<p>
								<label>'.__('Background image url','d_rtc').'</label>
								<br/>
								
									<input type="radio" name="digital_rtc_b" value="'.plugins_url( '/assets/img/empresas.png', __FILE__ ).'" '.$check1.' /><img src="'.plugins_url( '/assets/img/empresas.png', __FILE__ ).'" alt="" />
								
								</p>
								<p>
								<input type="radio" name="digital_rtc_b" value="'.plugins_url( '/assets/img/personal.png', __FILE__ ).'" '.$check2.' /><img src="'.plugins_url( '/assets/img/personal.png', __FILE__ ).'" alt="" />
								</p>
								<p>
								<input type="radio" name="digital_rtc_b" value="otro" '.$check3.' />'.__('Other. Put URL','d_rtc').': <input type="text" name="digital_stc_b_other" value="'.get_option('digital_rtc_b').'" />
								</p>
								<input type="submit" name="d_rtc_submit" value="'.__('Save','d_rtc').'" class="button button-primary button-large">

								<p>'.__('You can also add it to a single page by adding the shortcode in content','d_rtc').' [digital_rtc] </p>

							</div>

						

						</div>

						</form>

						<p class="about-description" style="padding-bottom:50px;">'.__('Powered by','d_rtc').' <a href="http://carlos-herrera.com" target="_blank">Carlos Herrera</a> '.__('for','d_rtc').' "<a href="http://www.soydigital.com" target="_blank">SoyDigital Network</a>"</p>

						

					</div>

				</div>';

				echo $data;

	}

$_REQUEST['d_rtc_submit']?digital_rtc_options_update($_REQUEST):false;



function digital_rtc_options_update($data)

{

	update_option('digital_rtc_varkey',$data['digital_rtc_varkey']);
	if($data['digital_rtc_b']=='otro')
	{
		$data['digital_rtc_b_other']<>''?update_option('digital_rtc_b',$data['digital_rtc_b_other']):update_option('digital_rtc_b','http://www.soydigital.com/images/webrtc-demo-iframe.png');
	}
	elseif($data['digital_rtc_b']=='')
	{
		update_option('digital_rtc_b','http://www.soydigital.com/images/webrtc-demo-iframe.png');
		
	}
	else
	{
		//die($data['digital_rtc_b']);
		update_option('digital_rtc_b',$data['digital_rtc_b']);
	}

	

	

}



add_action("admin_menu","menu_plugin_digital_rtc");

function web_rtc_load_textdomain() {

  load_plugin_textdomain( 'd_rtc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

}

add_action( 'plugins_loaded', 'web_rtc_load_textdomain' );

// Register and load the widget

function wpb_load_widget() {

	register_widget( 'digital_rtc' );

}

add_action( 'widgets_init', 'wpb_load_widget' );

function  menu_plugin_digital_rtc(){

   add_submenu_page("options-general.php","Digital-RTC", __('Set WebRTC for Wordpress SoyDigital','d_rtc'), 10, "digital_rtc", "admin_zone");

}



function web_rtc_scripts_basic()

{

     wp_register_script( 'soydigital_script', 'https://panel.soydigital.com/webRTC-Client.js', array(), null, false);

	 wp_enqueue_script( 'soydigital_script' );

	 wp_register_script( 'soydigital_script_custom',  plugins_url( '/assets/js/function.js', __FILE__ ));

	 wp_enqueue_script( 'soydigital_script_custom' );

	 wp_register_style( 'soydigital_css', 'https://panel.soydigital.com/styles_webRTC.css', array(), '20151407', 'all');

	 wp_enqueue_style( 'soydigital_css' );

	 wp_register_style( 'soydigital_css_custom', plugins_url( '/assets/css/style.css', __FILE__ ));

	 wp_enqueue_style( 'soydigital_css_custom' );

}

add_action( 'wp_enqueue_scripts', 'web_rtc_scripts_basic', 10 );



function web_rtc_add_script()

{

	$html='
	<style>
	#webRTCContainer.visible{background-image: url('.get_option('digital_rtc_b').') !important;    background-size: contain;}
	</style>
	<script type="text/javascript">

	var dialNumber = "'.get_option('digital_rtc_varkey').'";

	var xFrame = 0;

	var yFrame = 0;

	var  wRTC'.get_option('digital_rtc_varkey').';

	var dtmfKeyUp = function(event){

	var digit = "";

	//Alphanumeric Numbers

	 if ([48,49,50,51,52,53,54,55,56,57].indexOf(event.keyCode) != -1){

	 digit = String.fromCharCode(event.keyCode);

	 }

	 //Numpad Numbers

	 else if ([96,97,98,99,100,101,102,103,104,105].indexOf(event.keyCode) != -1){

	 var newKeyCode = event.keyCode - 48; //igualamos el keyCode al de los

	alfanumericos

	 digit = String.fromCharCode(newKeyCode);

	 }

	 if (digit == ""){

	 return false;

	 }

	 else {

	 doDTMF(digit);

	 }

	};

	function doConnect(){

	blockScreen();

	 wRTC'.get_option('digital_rtc_varkey').' = new webRTC_Client({flashTop: 0, flashLeft: 0});

	// Aqui "addEventListener" es valido solo para todos los navegadores excepto IE, que utiliza "attachEvent"

	if (!window.addEventListener){

	// como IE8 y anteriores no permite capturar eventos

	personalizados,

	 // entonces capturamos el evento onpropertychange

	 document.documentElement.attachEvent("onpropertychange",

	function(event) {

	 var propName = event.propertyName;

	

	 // if the property changed is the custom varFlashClient_ or eventFlashClient_ property

	 switch (propName) {

	 //variables varFlashClient_

	 case "onClientRegistered":

	 //console.log("demo onWebRTC_ClientConnected!!!");

	unblockScreen(); //desbloqueamos el div una vez que se ha cargado el FlashPhone/SipPhone

	 break;

	 case "onClientConnected":

	 //console.log("demo onWebRTC_ClientConnected!!!");

	unblockScreen(); //desbloqueamos el div una vez que se ha cargado el FlashPhone/SipPhone

	 break;

	 case "onCallStarted":

	 //console.log("demo onWebRTC_CallStarted!!!");

	document.getElementById(\'dialerWebRTC_01\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_01\').setAttribute("class", "hidden");

	document.getElementById(\'dialerWebRTC_02\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_02\').setAttribute("class", "visible");

	unblockScreen();

	//agregamos el handler del keyup para mandar DTMF con el teclado

	document.attachEvent("onkeyup",

	dtmfKeyUp);

	 break;

	 case "onCallTerminated":

	 //console.log("demo onWebRTC_CallTerminated!!!");

	document.getElementById(\'dialerWebRTC_02\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_02\').setAttribute("class", "hidden");

	document.getElementById(\'dialerWebRTC_01\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_01\').setAttribute("class", "visible");

	//quitamos el handler del keyup para mandar DTMF con el teclado pues ya no es necesario una vez terminada la llamada

	document.detachEvent("onkeyup",

	dtmfKeyUp);

	 break;

	 case "onError":

	 //console.log("demo onWebRTC_ClientError!!!");

	document.getElementById(\'dialerWebRTC_02\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_02\').setAttribute("class", "hidden");

	document.getElementById(\'dialerWebRTC_01\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_01\').setAttribute("class", "visible");

	var errorObject =

	document.documentElement["onWebRTC_ClientError"];

	if (errorObject.errorCode != 10){ //si es flashphone y no hay plugin de Flash instalado, dejamos bloqueado el contenedor unblockScreen();

	}

	alert(\'ERROR!! -> \' +

	errors[errorObject.errorCode]);

	 break;

	 }

	 });

	}

	else {

	window.addEventListener("onClientConnected",

	function(connectedEvent){

	console.log("demo onWebRTC_ClientConnected!!!");

	unblockScreen(); //desbloqueamos el div una vez que se ha cargado el FlashPhone/SipPhone

	}, false);

	window.addEventListener("onClientRegistered",

	function(connectedEvent){

	console.log("demo onWebRTC_ClientRegistered!!!");

	unblockScreen(); //desbloqueamos el div una vez que se ha cargado el FlashPhone/SipPhone

	}, false);

	window.addEventListener("onCallStarted",

	function(callStartedEvent){

	console.log("demo onWebRTC_CallStarted!!!");

	document.getElementById(\'dialerWebRTC_01\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_01\').setAttribute("class", "hidden");

	document.getElementById(\'dialerWebRTC_02\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_02\').setAttribute("class", "visible");

	unblockScreen();

	//agregamos el handler del keyup para mandar DTMF con el teclado

	window.addEventListener("keyup", dtmfKeyUp, false);

	}, false);

	window.addEventListener("onCallTerminated",

	function(callTerminatedEvent){

	console.log("demo onWebRTC_CallTerminated!!!");

	document.getElementById(\'dialerWebRTC_02\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_02\').setAttribute("class", "hidden");

	document.getElementById(\'dialerWebRTC_01\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_01\').setAttribute("class", "visible");

	//quitamos el handler del keyup para mandar DTMF con el teclado pues ya no es necesario una vez terminada la llamada

	window.removeEventListener("keyup", dtmfKeyUp, false);

	}, false);

	window.addEventListener("onError", function(errorEvent){

	console.log("demo onWebRTC_ClientError!!!");

	document.getElementById(\'dialerWebRTC_02\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_02\').setAttribute("class", "hidden");

	document.getElementById(\'dialerWebRTC_01\').removeAttribute("class");

	document.getElementById(\'dialerWebRTC_01\').setAttribute("class", "visible");

	if (errorEvent.errorCode != 10){ //si es flashphone y no hay plugin de Flash instalado, dejamos bloqueado el contenedor

	unblockScreen();

	}

	alert(\'ERROR!! -> \' + errors[errorEvent.errorCode]);

	}, false);

	}

	}

	function doCall(){

	if ( wRTC'.get_option('digital_rtc_varkey').'.getInterfaceType() != "flashPhone" ||

	( wRTC'.get_option('digital_rtc_varkey').'.getInterfaceType() == "flashPhone" &&  wRTC'.get_option('digital_rtc_varkey').'.isFlashPluginAvailable()

	== true)){

	misVars = [

	\'MIVAR=PROBANDO\',

	\'IVRGENERICA=LO QUE SEA\'

	];

	var response =  wRTC'.get_option('digital_rtc_varkey').'.makeCall(String(dialNumber), misVars);

	if (response == true){

	blockScreen();

	}

	}

	}

	function doHangup(){

	if ( wRTC'.get_option('digital_rtc_varkey').'.getInterfaceType() != "flashPhone" ||

	( wRTC'.get_option('digital_rtc_varkey').'.getInterfaceType() == "flashPhone" &&  wRTC'.get_option('digital_rtc_varkey').'.isFlashPluginAvailable()

	== true)){

	 wRTC'.get_option('digital_rtc_varkey').'.terminateCall();

	}

	}

	function doDTMF(digit){

	if ( wRTC'.get_option('digital_rtc_varkey').'.getInterfaceType() != "flashPhone" ||

	( wRTC'.get_option('digital_rtc_varkey').'.getInterfaceType() == "flashPhone" &&  wRTC'.get_option('digital_rtc_varkey').'.isFlashPluginAvailable()

	== true)){

	 wRTC'.get_option('digital_rtc_varkey').'.sendDTMF(digit);

	}

	}

	function embedWebRTCClient(container){

	var webRtcContainer = document.createElement("div");

	webRtcContainer.setAttribute("id", "webRTCContainer");

	webRtcContainer.setAttribute("class", "visible");

	var divContent = "";

	divContent += "<div id=\'dialerWebRTC_01\'>";

	divContent += "<img src=\'https://panel.virtualcenter360.es/img/icons/webRTC/makeCall.png\' onclick=\'doCall()\'>";

	divContent += "</div>";

	divContent += "<div id=\'dialerWebRTC_02\'>";

	divContent += "<input id=\'btnDTMF1\' class=\'webRTCButton\' type=\'button\' value=\'1\' onclick=\'doDTMF(\"1\")\'>";

	divContent += "<input id=\'btnDTMF2\' class=\'webRTCButton\' type=\'button\' value=\'2\' onclick=\'doDTMF(\"2\")\'>";

	divContent += "<input id=\'btnDTMF3\' class=\'webRTCButton\' type=\'button\' value=\'3\' onclick=\'doDTMF(\"3\")\'>";

	divContent += "<br>";

	divContent += "<input id=\'btnDTMF4\' class=\'webRTCButton\' type=\'button\' value=\'4\' onclick=\'doDTMF(\"4\")\'>";

	divContent += "<input id=\'btnDTMF5\' class=\'webRTCButton\' type=\'button\' value=\'5\' onclick=\'doDTMF(\"5\")\'>";

	divContent += "<input id=\'btnDTMF6\' class=\'webRTCButton\' type=\'button\' value=\'6\' onclick=\'doDTMF(\"6\")\'>";

	divContent += "<br>";

	divContent += "<input id=\'btnDTMF7\' class=\'webRTCButton\' type=\'button\' value=\'7\' onclick=\'doDTMF(\"7\")\'>";

	divContent += "<input id=\'btnDTMF8\' class=\'webRTCButton\' type=\'button\' value=\'8\' onclick=\'doDTMF(\"8\")\'>";

	divContent += "<input id=\'btnDTMF9\' class=\'webRTCButton\' type=\'button\' value=\'9\' onclick=\'doDTMF(\"9\")\'>";

	divContent += "<br>";

	divContent += "<input id=\'btnDTMF0\' class=\'webRTCButton\' type=\'button\' value=\'0\' onclick=\'doDTMF(\"0\")\'>";

	divContent += "<input id=\'btnDTMFAsterisk\' class=\'webRTCButton\' type=\'button\' value=\'*\' onclick=\'doDTMF(\"*\")\'>";

	divContent += "<input id=\'btnDTMFSharp\' class=\'webRTCButton\' type=\'button\' value=\'#\' onclick=\'doDTMF(\"#\")\'>";

	divContent += "<br>";

	divContent += "<input id=\'btnDummy\' class=\'webRTCButton\' type=\'button\' value=\'&nbsp;\'>";

	divContent += "<input id=\'btnHangup\' class=\'webRTCButton webRTCButtonHangUp\' type=\'button\' value=\'&nbsp;\' onclick=\'doHangup()\'>";

	divContent += "<input id=\'btnDummy\' class=\'webRTCButton\' type=\'button\' value=\'&nbsp;\'>";

	divContent += "</div>";

	//var myIframe = document.getElementById(\'frameCustomer\');

	//myIframe.contentWindow.document.body.innerHTML = webRtcContainer;

	container.appendChild(webRtcContainer);

	document.getElementById(\'webRTCContainer\').innerHTML = divContent;

	document.getElementById(\'webRTCContainer\').style.left = xFrame+"px";

	document.getElementById(\'webRTCContainer\').style.top = yFrame+"px";

	doConnect();

	}

	function blockScreen(){

	var loaderContainer = document.createElement("span");

	loaderContainer.setAttribute("id", "loaderGIF");

	document.getElementById(\'webRTCContainer\').appendChild(loaderContainer);

	}

	function unblockScreen(){

	var loaderContainer = document.getElementById("loaderGIF");

	if (loaderContainer != null)

	document.getElementById(\'webRTCContainer\').removeChild(loaderContainer);

	}

	

	</script>

	';

	echo $html;

}

add_action('wp_head','web_rtc_add_script');



class digital_rtc_shortcode {

	public static function shortcode_rtc( $atts, $content = "" ) {

		return digital_rtc::data_html_output();

	}

 }

 add_shortcode( 'digital_rtc', array( 'digital_rtc_shortcode', 'shortcode_rtc' ) );