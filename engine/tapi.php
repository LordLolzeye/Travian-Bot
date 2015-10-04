<?php
class tbot
{
  public $html = "";
  public $username = "";
  public $password = "";
  public $url = "";
  public $inConstruction = 0;
  public $ch;

  function connect($url, $username, $password)
  {
    $this->username = $username;
    $this->password = $password;
    $this->url = $url;
    $nothing = "";
    $login = $this->getLoginTimer($url);
    $postinfo = "name=" . $username . "&password=" . $password . "&lowRes=1&s1=Login&w=" . $nothing . "&login=" . $login;
    //LOGIN
    $this->ch = curl_init();
    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($this->ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($this->ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'cookie-name');  //empty
    curl_setopt($this->ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //empty
    curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->ch, CURLOPT_POST, true);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, $postinfo);
    curl_exec($this->ch);
    curl_setopt($this->ch, CURLOPT_URL, $url . "dorf1.php");
    $this->html = curl_exec($this->ch);
  }
  
  function isConnected()
  {
    $lgx = file_get_html($this->html);
    foreach($lgx->find('div') as $elm)
    {
      if(strpos($elm->class, 'villageListBarBox') !== false)
      {
            return 1;
      }
    }
    return 0;
  }

  function changeActivePage($vid, $page)
  {
    if($vid != 0)
    {
      $urlx = $this->url . $page . "?newdid=" . $vid . "&";
    }
    else
    {
      $urlx = $this->url . $page;
    }
    curl_setopt($this->ch, CURLOPT_URL, $urlx);
    curl_setopt($this->ch, CURLOPT_POST, false);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, "");
    $this->html = curl_exec($this->ch);
  }

  function getLoginTimer($url)
  {
    $lgx = file_get_html(file_get_contents($url, false, null, -1));
    foreach($lgx->find('input') as $elm)
    {
      if(strpos($elm->type, 'hidden') !== false)
      {
            $login = $elm->value;
      }
    }
    return $login;
  }

  function getHeroImage()
  {
    $html = file_get_html($this->html);
    foreach($html->find('img') as $elm)
    {
      if(strpos($elm->class, 'heroImage') !== false)
      {
        return $elm->src;
      }
    }
  }

  function getAdventure()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'adventure') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }

  function getIncomingReinforcements()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'd1') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }
  
  function getTroopEvade()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'd2') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }

  function getIncomingAttacksNumber()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'a1') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }

  function getNewVillageInProgress()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'settle') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }

  function getAttacksNumber()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'a2') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }
  
  function getSentReinforcements()
  {
    $html = file_get_html($this->html);
    foreach($html->find('span') as $elm)
    {
      if(strpos($elm->class, 'd2') !== false)
      {
        $nr = $elm->plaintext;
        $nr = explode(" ", $nr);
        $nr = $nr[0];
        return $nr;
      }
    }
    return 0;
  }  

  function getResourceLevels()
  {
    $html = file_get_html($this->html);
    foreach($html->find('map') as $elm)
    {
      if(strpos($elm->name, 'rx') !== false)
      {
        $nhtml = $elm;
      }
    }
    $resources = array();$i = 0;
    $html = file_get_html($nhtml);
    foreach($html->find('area') as $elm)
    {
      if($elm->href != 'dorf2.php')
      {
        $resources[$i] = substr($elm->alt, 0, strpos($elm->alt, "Nivel"));
        $resources[$i+1] = strstr($elm->alt, 'Nivel');
        $resources[$i+1] = trim(str_replace("Nivel", "", $resources[$i+1]));
        $resources[$i+2] = $elm->href;
        $i = $i + 3;
      }
    }
    return $resources;
  }

  function getBuildingLevels()
  {
    $html = file_get_html($this->html);
    foreach($html->find('map') as $elm)
    {
      if(strpos($elm->name, 'clickareas') !== false)
      {
        $nhtml = $elm;
      }
    }
    $building = array();$i = 0;
    $html = file_get_html($nhtml);
    foreach($html->find('area') as $elm)
    {
      $elmos = $elm->title;
      if(strpos($elmos, 'Nivel') !== false)
      {
        $building[$i] = substr($elmos, 0, strpos($elmos, "&lt;"));
        $building[$i+1] = strstr($elmos, 'Nivel');
        $building[$i+1] = substr($building[$i+1], 0, strpos($building[$i+1],'&lt;'));
        $woxos = explode(" ", $building[$i+1]);
        $building[$i+1] = trim($woxos[1]);
      }
      else
      {
        $building[$i] = "Santier";
        $building[$i+1] = -1;
      }
      $building[$i+2] = $elm->href;
      $i = $i + 3;
    }
    return $building;
  }

  function getBuildingUpgradeLink($link)
  {
    $this->changeActivePage(0, $link);
    $html = file_get_html($this->html);$x = 0;
    if($this->inConstruction < 1)
    {
      foreach($html->find('button') as $elm)
      {
        if(strpos($elm->class, 'green build') !== false)
        {
          $link = $elm->onclick;
          $link = str_replace("window.location.href = '", "", $link);
          $link = str_replace("'; return false;", "", $link);
          return $link;
        }
        if(strpos($elm->class, 'Destule resurse') !== false)
        {
          return -1;  // NO MATERIALS
        }
      }
    }
    else
    {
      return -2; //IN CONSTRUCTION
    }
    return -3;
  }

  function getPlayerVillages()
  {
    $html = file_get_html($this->html);$x = 0;
    foreach($html->find('div') as $elm)
    {
      if(strpos($elm->class, 'innerBox content') !== false)
      {
        if($x == 5)
        {
            $nhtml = $elm;
        }
        $x++;
      }
    }
    $html = file_get_html($nhtml);$villages = array();$impar = 1;
    foreach($html->find('a') as $elm)
    {
      if(strpos($elm->href, 'newdid') !== false)
      {
        $wox = str_replace("?newdid=", "", $elm->href);
        $wox = str_replace("&amp;", "", $wox);
        $villages[$impar] = $wox;
        $impar = $impar + 2;
      }
    }
    $par = 0;
    foreach($html->find('div') as $elm)
    {
      if(strpos($elm->class, 'name') !== false)
      {
        $villages[$par] = $elm->plaintext;
        $par = $par + 2;
      }
    }
    return $villages;
  }

  function getConstructionsInProgress()
  {
    $html = file_get_html($this->html);$x = 0;
    foreach($html->find('div') as $elm)
    {
      if(strpos($elm->class, 'boxes buildingList') !== false)
      {
        $nhtml = $elm;
      }
    }
    if(isset($nhtml))
    {
      $html = file_get_html($nhtml);$buildings = array();$par = 0;
      foreach($html->find('div') as $elm)
      {
        if(strpos($elm->class, 'name') !== false)
        {
          $woxy = str_replace('<span class="lvl">', '', $elm->plaintext);
          $woxy = str_replace('</span>', '', $woxy);
          $buildings[$par] = $woxy;
          $par = $par + 2;
        }
      }
      $html = file_get_html($nhtml);$impar = 1;
      foreach($html->find('span') as $elm)
      {
        if(strpos($elm->id, 'timer') !== false)
        {
          $buildings[$impar] = $elm->plaintext;
          $impar = $impar + 2;
        }
      }
    }
    if(isset($buildings))
    {
      if(count($buildings) >= 2)
      {
        $this->inConstruction = count($buildings)/2;
        return $buildings;
      }
    }
    return NULL;
  }

  function getVillageTroops()
  {
    $html = file_get_html($this->html);$x = 0;
    foreach($html->find('div') as $elm)
    {
      if(strpos($elm->class, 'boxes villageList units') !== false)
      {
        $nhtml = $elm;
        $x++;
      }
    }
    $html = file_get_html($nhtml);$troops = array();$impar = 1;
    foreach($html->find('td') as $elm)
    {
      if(strpos($elm->class, 'un') !== false)
      {
        $troops[$impar] = $elm->plaintext;
        $impar = $impar+2;
      }
    }
    $par = 0;
    foreach($html->find('td') as $elm)
    {
      if(strpos($elm->class, 'num') !== false)
      {
        $troops[$par] = $elm->plaintext;
        $par = $par+2;
      }
    }
    return $troops;
  }

  function getProductionPerHour()
  {
    $html = file_get_html($this->html);$x = 0;
    foreach($html->find('div') as $elm)
    {
      if(strpos($elm->class, 'boxes villageList production') !== false)
      {
        $nhtml = $elm;
        $x++;
      }
    }
    $html = file_get_html($nhtml);$production = array();$i = 0;
    foreach($html->find('td') as $elm)
    {
      if(strpos($elm->class, 'num') !== false)
      {
        $production[$i] = $elm->plaintext;
        $i++;
      }
    }
    return $production;
  }

  function getGranaryCapacity()
  {
    $granary = strstr($this->html, '<span class="value" id="stockBarGranary">');
    $granary = substr($granary, 0, strpos($granary, "</span>"));
    return $granary;
  }

  function getWarehouseCapacity()
  {
    $warehouse = strstr($this->html, '<span class="value" id="stockBarWarehouse">');
    $warehouse = substr($warehouse, 0, strpos($warehouse, "</span>"));
    return $warehouse;
  }

  function getResourceValue($id)
  {
    $value = strstr($this->html, '<span id="' . $id . '" class="value">');
    $value = substr($value, 0, strpos($value, "</span>"));
    return $value;
  }

  function disconnect()
  {
    curl_close($this->ch);
  }
}
?>