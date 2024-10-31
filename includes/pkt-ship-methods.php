<?php

include_once PICKIT_PATH . 'includes/pkt-class-utilities.php';

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/*
	function pickit_domicilio_init() {
		if ( ! class_exists( 'WC_Pickit_Domicilio_Ship' ) ) {
			class WC_Pickit_Domicilio_Ship extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */ /*
				public function __construct() {
					$this->id                 = 'pickit_domicilio_ship'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Domicilio Pickit' );  // Title shown in admin
					$this->method_description = __( 'Envio a Domicilio por medio de Pickit.' ); // Description shown in admin
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Envio a Domicilio por Pickit"; // This can be added as an setting but for this example its forced.
					$this->init();
					
					if (PKT_UTILITIES::obtenerTitleDom())
						$this->title = PKT_UTILITIES::obtenerTitleDom();

					add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				}

				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */ /*
				function init() {
                }
				
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */ /*
				public function calculate_shipping( $package = array() ) {
					$idPrecioFijo = PKT_UTILITIES::obtenerIdTipoPrecioFijo(); 	
					$idPrecioPorcentual = PKT_UTILITIES::obtenerIdTipoPrecioPorcentual();
					
					session_start();
					WC()->session->set("empezarCotizacion", true);
					
					$envio = array(
						"tipo" => "domicilio"
					);

					$requestDomPkt = PKT_UTILITIES::obtenerCotizacion($package, $envio);

					$rateDomPkt = $requestDomPkt["price"];

					$tipoPrecioEnvio = PKT_UTILITIES::obtenerTipoPrecioEnvioDom();

					if	($tipoPrecioEnvio == $idPrecioFijo && PKT_UTILITIES::obtenerPrecioFijoEnvioDom() )
						$rateDomPkt = PKT_UTILITIES::obtenerPrecioFijoEnvioDom();
					
					elseif	($tipoPrecioEnvio == $idPrecioPorcentual && PKT_UTILITIES::obtenerPrecioPorcentualEnvioDom() ) {
						$rateDomPkt *= PKT_UTILITIES::obtenerPrecioPorcentualEnvioDom();
						$rateDomPkt = (float)number_format($rateDomPkt, 2);
					}

					$label = PKT_UTILITIES::obtenerTitleDom();

					if ( PKT_UTILITIES::obtenerTipoDeEnvioDisponible() == 0 || $rateDomPkt < 0 || !$rateDomPkt )
					{
						$label = "";
						WC()->session->set("noSeIngresoCodigoPostal", true);
					} else {
						WC()->session->set("noSeIngresoCodigoPostal", false);
					}
					
					
					$rate = array(
						'id' => $this->id,
						'label' => $label,
						'cost' => $rateDomPkt,
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'pickit_domicilio_init' );

	function add_pickit_domicilio_shipping_methods( $methods ) {
		$methods['WC_Pickit_Domicilio_Ship'] = 'WC_Pickit_Domicilio_Ship';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_pickit_domicilio_shipping_methods' );
	*/

	function pickit_punto1_init() {
		if ( ! class_exists( 'WC_Pickit_Punto_1' ) ) {
			class WC_Pickit_Punto_1 extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'pickit_punto_1'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Punto Pickit 1' );  // Title shown in admin
					$this->method_description = __( 'Envio a Punto Pickit 1.' ); // Description shown in admin
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Envío a Punto Pickit 1"; // This can be added as an setting but for this example its forced.
					$this->init();

					add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				}
				
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
                }
                
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$idPrecioFijo = PKT_UTILITIES::obtenerIdTipoPrecioFijo();
					$idPrecioPorcentual = PKT_UTILITIES::obtenerIdTipoPrecioPorcentual();

					$ratePuntoPkt = 0;
						
					WC()->session->set("nombrePuntoPickitDos", NULL);
					WC()->session->set("nombrePuntoPickitTres", NULL);
					WC()->session->set("nombrePuntoPickitCuatro", NULL);
					WC()->session->set("nombrePuntoPickitCinco", NULL);

					$customer = new WC_Customer($package["user"]["ID"]);
					$customerdata = $customer->get_data();

					//$postCode = $customerdata["shipping"]["postcode"];
					$postCode = $customer->get_shipping_postcode();
					
					$puntosRequest = PKT_UTILITIES::obtenerPuntos($postCode);

					if(!$puntosRequest)
						return;

					$puntos["result"] = array();

					foreach ($puntosRequest["result"] as $punto)
						if ($punto["serviceType"] == "PP")
							array_push($puntos["result"], $punto);

					// Si hay al menos un punto disponible.
					if ($puntos["result"])
					{
						$punto = $puntos["result"][0];
						$idPunto = $punto["idService"];

						WC()->session->set("noSeIngresoCodigoPostal", false);
						WC()->session->set("noHayPuntos", false);
						WC()->session->set("empezarCotizacion", true);
						WC()->session->set("idPuntoPickitUno", $idPunto);
						
						$envio = array(
							"tipo" => "punto",
							"idPunto" => $idPunto
						);
						
						$requestPuntoPkt = PKT_UTILITIES::obtenerCotizacion($package, $envio);

						$ratePuntoPkt = $requestPuntoPkt["price"];
						
						$tipoPrecioEnvio = PKT_UTILITIES::obtenerTipoPrecioEnvioPunto();

						if ( $tipoPrecioEnvio == $idPrecioFijo ) {
							if ( PKT_UTILITIES::obtenerPrecioFijoEnvioPunto() )
							$ratePuntoPkt = PKT_UTILITIES::obtenerPrecioFijoEnvioPunto();

							if ( !PKT_UTILITIES::obtenerPrecioFijoEnvioPunto() )
							$ratePuntoPkt = 0;
						}
						elseif ( $tipoPrecioEnvio == $idPrecioPorcentual && PKT_UTILITIES::obtenerPrecioPorcentualEnvioPunto() ) {
							$ratePuntoPkt *= PKT_UTILITIES::obtenerPrecioPorcentualEnvioPunto();
							$ratePuntoPkt = (float)number_format($ratePuntoPkt, 2);
						}

						WC()->session->set( "precioPuntoPickit", NULL );

						// Comprueba que exista un segundo punto.
						if ($puntos["result"][1]){
							WC()->session->set("dosPuntosDisponibles", true);
							WC()->session->set("precioPuntoPickit", $ratePuntoPkt);
							WC()->session->set("nombrePuntoPickitDos", $puntos["result"][1]["name"] . ", " . $puntos["result"][1]["address"] . ", CP: " . $puntos["result"][1]["postalCode"]);
							WC()->session->set("idPuntoPickitDos", $puntos["result"][1]["idService"]);

							// Comprueba que exista un tercer punto.
							if ($puntos["result"][2]){
								WC()->session->set("tresPuntosDisponibles", true);
								WC()->session->set("nombrePuntoPickitTres", $puntos["result"][2]["name"] . ", " . $puntos["result"][2]["address"] . ", CP: " . $puntos["result"][2]["postalCode"]);
								WC()->session->set("idPuntoPickitTres", $puntos["result"][2]["idService"]);
								
								// Comprueba que exista un tercer punto.
								if ($puntos["result"][3]){
									WC()->session->set("cuatroPuntosDisponibles", true);
									WC()->session->set("nombrePuntoPickitCuatro", $puntos["result"][3]["name"] . ", " . $puntos["result"][3]["address"] . ", CP: " . $puntos["result"][3]["postalCode"]);
									WC()->session->set("idPuntoPickitCuatro", $puntos["result"][3]["idService"]);

									// Comprueba que exista un tercer punto.
									if ($puntos["result"][4]){
										WC()->session->set("cincoPuntosDisponibles", true);
										WC()->session->set("nombrePuntoPickitCinco", $puntos["result"][4]["name"] . ", " . $puntos["result"][4]["address"] . ", CP: " . $puntos["result"][4]["postalCode"]);
										WC()->session->set("idPuntoPickitCinco", $puntos["result"][4]["idService"]);
									}
								}
							}
						}

						$label = $this->method_title . ": " . $punto["name"] . ", " . $punto["address"] . ", CP: " . $punto["postalCode"];

						//if( PKT_UTILITIES::obtenerTipoDeEnvioDisponible() == 1 )
						//	$label = "";

						if ( $ratePuntoPkt < 0 )
							$label = "";

					} else {
						if ( !WC()->session->get("noSeIngresoCodigoPostal") )
							WC()->session->set("noHayPuntos", true);
						$label = "";
					}

					$rate = array(
						'id' => $this->id,
						'label' => $label,
						'cost' => $ratePuntoPkt,
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'pickit_punto1_init' );

	function add_pickit_punto_1_shipping_method( $methods ) {
		$methods['WC_Pickit_Punto_1'] = 'WC_Pickit_Punto_1';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_pickit_punto_1_shipping_method' );

	function pickit_punto2_init() {
		if ( ! class_exists( 'WC_Pickit_Punto_2' ) ) {
			class WC_Pickit_Punto_2 extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'pickit_punto_2'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Punto Pickit 2' );  // Title shown in admin
					$this->method_description = __( 'Envio a Punto Pickit 2.' ); // Description shown in admin
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Envío a Punto Pickit 2"; // This can be added as an setting but for this example its forced.
					$this->init();

					add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				}
				
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
                }
                
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$idPrecioFijo = PKT_UTILITIES::obtenerIdTipoPrecioFijo();
					$idPrecioPorcentual = PKT_UTILITIES::obtenerIdTipoPrecioPorcentual();

					$ratePuntoPkt = 0;

					if ( WC()->session->get("dosPuntosDisponibles") )
					{
						WC()->session->set( "dosPuntosDisponibles", NULL);
						$idPunto = WC()->session->get( "idPuntoPickitDos" );
						$ratePuntoPkt = WC()->session->get( "precioPuntoPickit" );

						if (WC()->session->get("nombrePuntoPickitDos"))
							$label = $this->method_title . ": " . WC()->session->get( "nombrePuntoPickitDos" );

						//if( PKT_UTILITIES::obtenerTipoDeEnvioDisponible() == 1 )
						//	$label = "";

						if ( $ratePuntoPkt < 0 )
							$label = "";
					}
					else
						$label = '';

					$rate = array(
						'id' => $this->id,
						'label' => $label,
						'cost' => $ratePuntoPkt,
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'pickit_punto2_init' );

	function add_pickit_punto_2_shipping_method( $methods ) {
		$methods['WC_Pickit_Punto_2'] = 'WC_Pickit_Punto_2';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_pickit_punto_2_shipping_method' );

	function pickit_punto3_init() {
		if ( ! class_exists( 'WC_Pickit_Punto_3' ) ) {
			class WC_Pickit_Punto_3 extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'pickit_punto_3'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Punto Pickit 3' );  // Title shown in admin
					$this->method_description = __( 'Envio a Punto Pickit 3.' ); // Description shown in admin
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Envío a Punto Pickit 3"; // This can be added as an setting but for this example its forced.
					$this->init();

					add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				}
				
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
                }
                
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$idPrecioFijo = PKT_UTILITIES::obtenerIdTipoPrecioFijo();
					$idPrecioPorcentual = PKT_UTILITIES::obtenerIdTipoPrecioPorcentual();
					
					$ratePuntoPkt = 0;

					if ( WC()->session->get("tresPuntosDisponibles") )
					{
						WC()->session->set( "tresPuntosDisponibles", NULL);
						$idPunto = WC()->session->get( "idPuntoPickitTres" );
						$ratePuntoPkt = WC()->session->get( "precioPuntoPickit" );

						if(WC()->session->get("nombrePuntoPickitTres"))
							$label = $this->method_title . ": " . WC()->session->get( "nombrePuntoPickitTres" );

						//if( PKT_UTILITIES::obtenerTipoDeEnvioDisponible() == 1 )
						//	$label = "";

						if ( $ratePuntoPkt < 0 )
							$label = "";
					}
					else
						$label = '';

					$rate = array(
						'id' => $this->id,
						'label' => $label,
						'cost' => $ratePuntoPkt,
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'pickit_punto3_init' );

	function add_pickit_punto_3_shipping_method( $methods ) {
		$methods['WC_Pickit_Punto_3'] = 'WC_Pickit_Punto_3';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_pickit_punto_3_shipping_method' );
	 

	function pickit_punto4_init() {
		if ( ! class_exists( 'WC_Pickit_Punto_4' ) ) {
			class WC_Pickit_Punto_4 extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'pickit_punto_4'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Punto Pickit 4' );  // Title shown in admin
					$this->method_description = __( 'Envio a Punto Pickit 4.' ); // Description shown in admin
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Envío a Punto Pickit 4"; // This can be added as an setting but for this example its forced.
					$this->init();

					add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				}
				
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
                }
                
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$idPrecioFijo = PKT_UTILITIES::obtenerIdTipoPrecioFijo();
					$idPrecioPorcentual = PKT_UTILITIES::obtenerIdTipoPrecioPorcentual();

					$ratePuntoPkt = 0;
					
					if ( WC()->session->get("cuatroPuntosDisponibles") )
					{
						WC()->session->set( "cuatroPuntosDisponibles", NULL);
						$idPunto = WC()->session->get( "idPuntoPickitCuatro" );
						$ratePuntoPkt = WC()->session->get( "precioPuntoPickit" );

						if(WC()->session->get("nombrePuntoPickitCuatro"))
							$label = $this->method_title . ": " . WC()->session->get( "nombrePuntoPickitCuatro" );

						//if( PKT_UTILITIES::obtenerTipoDeEnvioDisponible() == 1 )
						//	$label = "";

						if ( $ratePuntoPkt < 0 )
							$label = "";
					}
					else
						$label = '';

					$rate = array(
						'id' => $this->id,
						'label' => $label,
						'cost' => $ratePuntoPkt,
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'pickit_punto4_init' );

	function add_pickit_punto_4_shipping_method( $methods ) {
		$methods['WC_Pickit_Punto_4'] = 'WC_Pickit_Punto_4';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_pickit_punto_4_shipping_method' );
	 

	function pickit_punto5_init() {
		if ( ! class_exists( 'WC_Pickit_Punto_5' ) ) {
			class WC_Pickit_Punto_5 extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'pickit_punto_5'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Punto Pickit 5' );  // Title shown in admin
					$this->method_description = __( 'Envio a Punto Pickit 5.' ); // Description shown in admin
					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Envío a Punto Pickit 5"; // This can be added as an setting but for this example its forced.
					$this->init();

					add_action('woocommerce_update_options_shipping_methods', array(&$this, 'process_admin_options'));
				}
				
				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
                }
                
				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$idPrecioFijo = PKT_UTILITIES::obtenerIdTipoPrecioFijo();
					$idPrecioPorcentual = PKT_UTILITIES::obtenerIdTipoPrecioPorcentual();
					
					$ratePuntoPkt = 0;

					if ( WC()->session->get("cincoPuntosDisponibles") )
					{
						WC()->session->set( "cincoPuntosDisponibles", NULL);
						$idPunto = WC()->session->get( "idPuntoPickitCinco" );
						$ratePuntoPkt = WC()->session->get( "precioPuntoPickit" );

						if(WC()->session->get("nombrePuntoPickitCinco"))
							$label = $this->method_title . ": " . WC()->session->get( "nombrePuntoPickitCinco" );

						//if( PKT_UTILITIES::obtenerTipoDeEnvioDisponible() == 1 )
						//	$label = "";

						if ( $ratePuntoPkt < 0 )
							$label = "";
					}
					else
						$label = '';

					$rate = array(
						'id' => $this->id,
						'label' => $label,
						'cost' => $ratePuntoPkt,
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}
	add_action( 'woocommerce_shipping_init', 'pickit_punto5_init' );

	function add_pickit_punto_5_shipping_method( $methods ) {
		$methods['WC_Pickit_Punto_5'] = 'WC_Pickit_Punto_5';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_pickit_punto_5_shipping_method' );
	 
	
    add_filter( 'woocommerce_get_sections_shipping', 'removeShippingMethodsSections' );
    function removeShippingMethodsSections( $sections ) {
        //unset($sections['pickit_domicilio_ship']);
        unset($sections['pickit_punto_1']);
        unset($sections['pickit_punto_2']);
        unset($sections['pickit_punto_3']);
        unset($sections['pickit_punto_4']);
        unset($sections['pickit_punto_5']);

        return $sections;
    }
}