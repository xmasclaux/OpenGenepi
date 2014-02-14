<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <?php
    //This class will used in order to define MainMenu icons, depending on user credentials
    define('USERS_AUTH',dirname(__FILE__).'/../modules/auth/lib/usersAuth.class.php');
    require_once(USERS_AUTH);
    ?>

    <title><?php include_slot('title')?></title>

    <script type="text/javascript">
         window.onresize = resize;
         $(document).ready( function () {
             resize();
             $("body").css('visibility','visible');

             $('span[id="aboutSpan"]').click(function(){
                    $("#about").dialog( {
                        width: 700,
                        close: false,
                        resizable: false,
                        modal: true,
                        draggable : false,
                        buttons: {
                            <?php echo __('Ok') ?>: function() {
                                    $(this).dialog("close");
                            }
                        }
                    } );
                });
         });
    </script>
  </head>
  <body>
      <div id="about" title="<?php echo __('About').' GENEPI'?>" style="display:none">
        <p><?php echo 'GENEPI'?></p>
        <p><?php echo 'GEstion Numérique des Espaces Publics Internet'?></p>
        <p><?php echo __('Version').' 0.9.1'?></p>
        <p>
            <?php echo __('GENEPI is distributed under the terms of the').' '.'<a href="http://www.gnu.org/licenses/gpl.html"><b>'.'GNU General Public License'.'</b>'.'</a>'.'.'?>
        </p>
        <p>
            <?php echo __('This project is an initiative of the').' '.'<a href="http://www.pole-numerique.fr"><b>'.'Pôle Numérique'.'</b>'.'</a>'.'.'?>
        </p>
        <p>
            <?php echo __('Original process requestors').__(': ').'Emmanuel Mayoud, Thierry Glantzmann'.'.'?>
        </p>
        <p>
            <?php echo __('It has been developped during the Industrial Projects of the Engineering School').' '.'<a href="http://esisar.grenoble-inp.fr"><b>'.'Grenoble INP - ESISAR'.'</b>'.'</a>'.'.'?>
        </p>
        <p>
            <?php echo __('Student developpers').__(': ').'Pierre Boitel, Bastien Libersa, Paul Périé'.' - '.__('Supervision').__(': ').'Heinrich Bley'.'.'?>
        </p>
        <p>
            <?php echo __('The name GENEPI was proposed by Grégory Watremez, director of the media library of Romans-sur-Isère, and chosen by the Drôme EPI moderators.')?>
        </p>
        <p>
            <?php echo __('The original project has been funded by').__(':') ?>
        </p>
        <ul>
            <li><?php echo '<a href="http://www.ladrome.fr"><b>'. __('The Drôme department').'</b>'.'</a>' ?></li>
            <li><?php echo '<a href="http://www.rhonealpes.fr"><b>'. __('The Rhône-Alpes region').'</b>'.'</a>' ?></li>
            <li><?php echo '<a href="http://europa.eu"><b>'. __('The Europe').'</b>'.'</a>'.'.' ?></li>
        </ul>
        <p>
            <?php echo __('For further information').__(': ').'<a href="http://www.opengenepi.org"><b>'.'http://www.opengenepi.org'.'</b></a>'.'.'?>
        </p>
    </div>

    <div id="ban"></div>

    <div id="menus">
            <div id="configurationAndUserName">
                <?php $usersAuth = new usersAuth();
                        if ($usersAuth->isAdmin()):  //if the user is an admin, the whole configuration menu
                ?>
                    <div id="configurationMenu">
                        <span>
                            <a href="<?php echo url_for('auth/disconnect') ?>">
                                <?php echo image_tag('exit.png', array('class' => 'config_picture', 'title' => __('Disconnect'))) ?>
                            </a>
                        </span>
                        <span>
                            <?php echo image_tag('redBar.png', array('class' => 'config_stripe')) ?>
                        </span>
                        <span>
                            <a href="<?php echo url_for('act/index')?>">
                                <?php echo image_tag('configure.png', array('class' => 'config_picture', 'title' => __('Configuration'))) ?>
                            </a>
                        </span>
                        <span>
                            <?php echo image_tag('redBar.png', array('class' => 'config_stripe')) ?>
                        </span>
                        <span id="aboutSpan">
                            <a>
                                <?php echo image_tag('about.png', array('class' => 'config_picture', 'title' => __('About'))) ?>
                            </a>
                        </span>
                    </div>
                <?php else: //else, he can only access to the help and to the disconnection ?>
                    <div id="configurationMenuViewer">
                        <span>
                            <a href="<?php echo url_for('auth/disconnect') ?>">
                                <?php echo image_tag('exit.png', array('class' => 'config_picture', 'title' => 'Disconnect')) ?>
                            </a>
                        </span>
                        <span>
                            <?php echo image_tag('redBar.png', array('class' => 'config_stripe')) ?>
                        </span>
                        <span id="aboutSpan">
                            <a>
                                <?php echo image_tag('about.png', array('class' => 'config_picture', 'title' => __('About'))) ?>
                            </a>
                        </span>
                    </div>
            <?php endif; ?>
            <div id="UserNameDisplay">
                <?php echo $usersAuth->getName()." ".$usersAuth->getSurname();?>
            </div>

        </div>
        <div id="mainMenu">
            <span id="topLeftLogo">
                <?php echo image_tag('/uploads/images/logo.png?'.microtime(), array('height' => '90')) ?>
            </span>
             <div id="scrollButtons" >
                <span id="rightScroll" class="rightScroll" onmouseout="stopScroll();" onmouseover="rightScroll();"></span>
                <div id="slideMenu" >
                    <ul id="list" >
                        <?php $modules = sfContext::getInstance()->get('Modules');
                            $end_if = 1;
                            foreach ($modules as $module) {

                                /*Compare User Credentials to Action Credentials*/
                                /*According to the case, the slide menu is different*/
                                if(!is_null($module->getMenuEntryName())){
                                    $context = sfContext::getInstance();
                                    $action = $context->getController()->getAction($module->getModuleName(), 'index');
                                    $credential =  $action->getCredential();
                                    $haveCredentials =$this->context->getUser()->hasCredential($credential);
                                }
                                else
                                {
                                    $haveCredentials=false;
                                }

                                  if($haveCredentials){
                                      if ($end_if && !strcasecmp($module->getModuleName(),sfContext::getInstance()->getModuleName()))
                                      {
                                          echo "<li><a style=\"border:2px solid #aaaaaa; background: #333333;\" href=\"".url_for($module->getModuleName().'/index')."\">".__($module->getMenuEntryName())."</a></li>";
                                          $end_if = 0;
                                      }
                                      else
                                      {
                                        echo "<li><a href=\"".url_for($module->getModuleName().'/index')."\">".__($module->getMenuEntryName())."</a></li>";
                                      }
                                  }
                              }
                        ?>
                    </ul>
                </div>
                <span id="leftScroll" class="leftScroll" onmouseout="stopScroll();" onmouseover="leftScroll();"></span>
            </div>
        </div>
    </div>

    <div id="pageFrame">
        <span id="feedbackFrame"><?php include_slot('feedbackFrame') ?></span>

        <span id="pageContent">
            <?php echo $sf_content ?>
        </span>

        <span id="secondaryMenu"><?php include_slot('secondaryMenu') ?></span>
     </div>

    <div id="footer"></div>
  </body>

</html>