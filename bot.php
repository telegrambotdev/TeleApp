<?php

# Data creazione framework: 04/09/2019

# Copyright Adriano Palma

$Adriano = 588347428;

class Bot {

  public function __construct($token,$json = false){

    if($json == false){
      $this->json = file_get_contents('php://input');
    }

    $this->bot = $token;

    #Variabili

    $this->update = json_decode($this->json, TRUE);

    if($this->update != null){

    if(isset($this->update['message'])){
    $this->edit = false;
    $this->messageType = 'message';
    } else if(isset($this->update['edited_message'])){
    $this->edit = true;
    $this->messageType = 'edited_message';
    }

    if(isset($this->update['callback_query']['id'])){ //Se l'update è un callback_query
      if(isset($this->update['callback_query']['from']['last_name'])){
        $this->callback_cognome = $this->update['callback_query']['from']['last_name']; //cognome dell'utente che ha cliccato il pulsante
      }
      $this->update_id = $this->update['update_id']; //ID dell'update
      $this->callback_query_id = $this->update['callback_query']['id']; //callback_query_id
      $this->callback_user_id = $this->update['callback_query']['from']['id']; //ID dell'utente che ha cliccato il pulsante
      $this->callback_is_bot = $this->update['callback_query']['from']['is_bot']; //is_bot dell'utente che ha cliccato il pulsante
      $this->callback_nome = $this->update['callback_query']['from']['first_name']; //nome dell'utente che ha cliccato il pulsante
      $this->callback_lingua = $this->update['callback_query']['from']['language_code']; //lingua dell'utente che ha cliccato il pulsante
      $this->callback_message_id = $this->update['callback_query']['message']['message_id']; //Message_id del messaggio originale
      $this->callback_bot_id = $this->update['callback_query']['message']['from']['id']; //ID del bot del callback_query
      $this->callback_bot_is_bot = $this->update['callback_query']['message']['from']['is_bot']; //is_bot del bot del callback_query
      $this->callback_bot_nome = $this->update['callback_query']['message']['from']['first_name']; //nome del bot del callback_query
      $this->callback_bot_username = $this->update['callback_query']['message']['from']['username']; //Username del bot del callback_query
      $this->callback_chat_id = $this->update['callback_query']['message']['chat']['id']; //ID del gruppo/chat del callback_query
      $this->callback_chat_title = $this->update['callback_query']['message']['chat']['title']; //Titolo del gruppo/chat del callback_query
      $this->callback_chat_type = $this->update['callback_query']['message']['chat']['type']; //Tipo della chat (gruppo, supergruppo, canale, private)
      $this->callback_time = $this->update['callback_query']['message']['date']; //Timestamp del querydata
      $this->callback_text = $this->update['callback_query']['message']['text']; //Testo del messaggio a cui l'utente ha cliccato
      $this->callback_entities = $this->update['callback_query']['message']['entities']; //Array degli entities
      $this->callback_inline_keyboard = $this->update['callback_query']['message']['reply_markup']['inline_keyboard']; //Array della tastiera del messaggio a cui l'utente ha cliccato
      $this->callback_chat_instance = $this->update['callback_query']['chat_instance']; //istanza chat
      $this->callback_data = $this->update['callback_query']['data']; //callback_data
    } else if(isset($this->update[$this->messageType]['message_id'])){ //Se l'update è un messaggio
      if(isset($this->update[$this->messageType]['chat']['first_name'])){ //Se il tipochat è private
          $this->nome_chat = $this->update[$this->messageType]['chat']['first_name'];
        if(isset($this->update[$this->messageType]['from']['last_name'])){
          $this->cognome = $this->update[$this->messageType]['from']['last_name']; //cognome dell'utente
        }
      }
      if(isset($this->update[$this->messageType]['sticker'])){ #Se è uno sticker
        $this->is_animated = $this->update[$this->messageType]['sticker']['is_animated']; //Se è animato [true/false]
        $this->width_sticker = $this->update[$this->messageType]['sticker']['width'];
        $this->height_sticker = $this->update[$this->messageType]['sticker']['height'];
        $this->emoji_sticker = $this->update[$this->messageType]['sticker']['emoji'];
        $this->nome_sticker = $this->update[$this->messageType]['sticker']['set_name'];
        $this->sticker = $this->update[$this->messageType]['sticker']['file_id'];
        $this->size_sticker = $this->update[$this->messageType]['sticker']['file_size'];
      }
      if(isset($this->update[$this->messageType]['new_chat_participant'])){ //Se c'è un nuovo partecipante alla chat
        $this->nuovo_membro = $this->update[$this->messageType]['new_chat_member']; //Nuovo membro
        $this->nuovo_membro_id = $this->update[$this->messageType]['new_chat_member']['id']; //Nuovo membro
        $this->nuovo_membro_nome = $this->update['message']['new_chat_member']['first_name']; //Nuovo membro
        if(isset($this->update[$this->messageType]['new_chat_member']['last_name'])){
          $this->nuovo_membro_cognome = $this->update[$this->messageType]['new_chat_member']['last_name']; //Nuovo membro
        }
        if(isset($this->update[$this->messageType]['new_chat_member']['username'])){
          $this->nuovo_membro_username = $this->update[$this->messageType]['new_chat_member']['username']; //Nuovo membro
        }
        $this->nuovo_membro_is_bot = $this->update[$this->messageType]['new_chat_member']['is_bot']; //Nuovo membro
        $this->nuovo_partecipante = $this->update[$this->messageType]['new_chat_participant']; //Nuovo partecipante
        $this->nuovi_membri = $this->update[$this->messageType]['new_chat_members']; //Array dei nuovi partecipanti
      }
      if(isset($this->update[$this->messageType]['photo'])){ //Se è una foto
        $this->didascalia = $this->update[$this->messageType]['caption']; //Didascalia foto
        $this->file_unique_id = $this->update[$this->messageType]['photo']['file_unique_id']; //file_id del file
        $this->foto = $this->update[$this->messageType]['photo']['2']['file_id']; //File_id della foto inviata
      }
      if(isset($this->update[$this->messageType]['document'])){ //Se è un file/documento
        $this->nome_file = $this->update[$this->messageType]['document']['file_name']; //Nome del file
        $this->tipo_file = $this->update[$this->messageType]['document']['mime_type']; //Estensione del file
        $this->file = $this->update[$this->messageType]['document']['file_id']; //file_id del file
        $this->file_unique_id = $this->update[$this->messageType]['document']['file_unique_id']; //file_id del file
        $this->tipo_file = $this->update[$this->messageType]['document']['mime_type']; //Estensione del file
        $this->size_file = $this->update[$this->messageType]['document']['file_size']; //Peso del file in byte
      }
      if(isset($this->update[$this->messageType]['video'])){ //Se è un video
        $this->durata_video = $this->update[$this->messageType]['video']['duration']; //Durata video
        $this->video = $this->update[$this->messageType]['video']['file_id']; //File_id del video
        $this->tipo_video = $this->update[$this->messageType]['video']['mime_type']; //Estensione del video
        $this->file_unique_id = $this->update[$this->messageType]['video']['file_unique_id']; //file_id del file
        $this->width_video = $this->update[$this->messageType]['video']['width'];
        $this->size_video = $this->update[$this->messageType]['video']['file_size'];
        $this->height_video = $this->update[$this->messageType]['video']['height'];
      }
      if(isset($this->update[$this->messageType]['animation'])){ //Se è una gif
        $this->durata_gif = $this->update[$this->messageType]['animation']['duration']; //Durata video
        $this->gif = $this->update[$this->messageType]['animation']['file_id']; //File_id del video
        $this->tipo_gif = $this->update[$this->messageType]['animation']['mime_type']; //Estensione del video
        $this->width_gif = $this->update[$this->messageType]['animation']['width'];
        $this->size_gif = $this->update[$this->messageType]['animation']['file_size'];
        $this->height_gif = $this->update[$this->messageType]['animation']['height'];
      }
      if(isset($this->update['channel_post'])){
        $this->message_id = $this->update['channel_post']['message_id'];
        $this->canale_id = $this->update['channel_post']['chat']['id'];
        $this->didascalia = $this->update['channel_post']['caption']; //Didascalia foto
        $this->testo_canale = $this->update['channel_post']['text'];
      }
      $this->entities = $this->update[$this->messageType]['entities']; //Entities del messaggio
      $this->update_id = $this->update['update_id']; //ID dell'update
      $this->message_id = $this->update[$this->messageType]['message_id']; //Message_id del messaggio
      $this->user_id = $this->update[$this->messageType]['from']['id']; //ID dell'utente
      $this->is_bot = $this->update[$this->messageType]['from']['is_bot']; //is_bot dell'utente
      $this->nome = $this->update[$this->messageType]['from']['first_name']; //nome dell'utente
      $this->username = $this->update[$this->messageType]['from']['username']; //username dell'utente
      $this->lingua = $this->update[$this->messageType]['from']['language_code']; //Lingua dell'utente
      $this->chat_id = $this->update[$this->messageType]['chat']['id']; //ID della chat (gruppo, canale, utente)
      $this->username_chat = $this->update[$this->messageType]['chat']['username']; //username della chat (gruppo, canale, utente)
      $this->tipo_chat = $this->update[$this->messageType]['chat']['type']; //tipo della chat (gruppo, canale, utente)
      $this->time = $this->update[$this->messageType]['chat']['date']; //tempo della chat (gruppo, canale, utente)
      $this->text = $this->update[$this->messageType]['text']; //testo del messaggio
      if(isset($this->update[$this->messageType]['chat']['title'])){
        $this->nome_chat = $this->update[$this->messageType]['chat']['title']; //titolo chat
      }
      if(isset($this->update[$this->messageType]['forward_sender_name'])){ //Se il messaggio è INOLTRATO, ma l'utente ha la privacy mode ON
        $this->forward_sender_name = $this->update[$this->messageType]['forward_sender_name']; //Nome del tizio forwardato
        $this->forward_date = $this->update[$this->messageType]['forward_date']; //Timestamp messaggio forwardato
        $this->forward_text = $this->update[$this->messageType]['text']; //Testo del messaggio forwardato (privacy mode on) [è LO STESSO DI $text]
      } else if(isset($this->update[$this->messageType]['forward_from'])){ //Se il messaggio è INOLTRATO
        $this->forward_chat_id = $this->update[$this->messageType]['forward_from']['id']; //ID del messaggio forwardato (non message_id)
        $this->forward_is_bot = $this->update[$this->messageType]['forward_from']['is_bot']; //is_bot del messaggio forwardato
        $this->forward_nome = $this->update[$this->messageType]['forward_from']['first_name']; //nome del messaggio forwardato
        $this->forward_username = $this->update[$this->messageType]['forward_from']['username']; //username del messaggio forwardato
        $this->forward_text = $this->update[$this->messageType]['text']; //Testo del messaggio forwardato (privacy mode on) [è LO STESSO DI $text]
        $this->forward_date = $this->update[$this->messageType]['forward_date']; //Timestamp messaggio forwardato
        if(isset($this->update[$this->messageType]['forward_from']['last_name'])){ //se è presente il cognome
          $this->forward_cognome = $this->update[$this->messageType]['forward_from']['last_name']; //cognome del messaggio forwardato
        }
      } else if(isset($this->update[$this->messageType]['forward_from_chat'])){
        $this->forward_chat_id = $this->update[$this->messageType]['forward_from_chat']['id'];
        $this->forward_title = $this->update[$this->messageType]['forward_from_chat']['title'];
        $this->forward_username = $this->update[$this->messageType]['forward_from_chat']['username'];
        $this->forward_type = $this->update[$this->messageType]['forward_from_chat']['type'];
        $this->forward_from_message_id = $this->update[$this->messageType]['forward_from_message_id'];
        $this->forward_date = $this->update[$this->messageType]['forward_date'];
      }
      if(isset($this->update[$this->messageType]['reply_to_message']['message_id'])){ //Se si sta rispondendo ad un messaggio
        $this->reply_message_id = $this->update[$this->messageType]['reply_to_message']['message_id']; //ID del messaggio a cui si stà rispondendo
        $this->reply_user_id = $this->update[$this->messageType]['reply_to_message']['from']['id']; //id dell'utente a cui si ha risposto
        $this->reply_is_bot = $this->update[$this->messageType]['reply_to_message']['from']['is_bot']; //is_bot dell'utente o bot a cui si ha risposto
        $this->reply_nome = $this->update[$this->messageType]['reply_to_message']['from']['first_name']; //Nome dell'utente a cui si ha risposto
      if(isset($this->update[$this->messageType]['reply_to_message']['from']['last_name'])){ //Verifica se l'utente ha il cognome
        $this->reply_cognome = $this->update[$this->messageType]['reply_to_message']['from']['last_name']; //cognome dell'utente
      }
        $this->reply_tipo = $this->update[$this->messageType]['reply_to_message']['from']['type']; //tipo del messaggio nella chat a cui si stà rispondendo
        $this->reply_time = $this->update[$this->messageType]['reply_to_message']['from']['date']; //data messaggio a cui si stà rispondendo
        $this->reply_username = $this->update[$this->messageType]['reply_to_message']['from']['username']; //username della chat (utente, gruppo, canale) del messaggio a cui si sta rispondendo
        $this->reply_chat_id = $this->update[$this->messageType]['reply_to_message']['chat']['id']; //ID della chat (utente, gruppo, canale) del messaggio a cui si sta rispondendo
        $this->reply_chat_nome = $this->update[$this->messageType]['reply_to_message']['chat']['first_name']; //nome della chat (utente, gruppo, canale) del messaggio a cui si sta rispondendo
        $this->reply_chat_cognome = $this->update[$this->messageType]['reply_to_message']['chat']['last_name']; //cognome della chat (utente, gruppo, canale) del messaggio a cui si sta rispondendo
        $this->reply_chat_tipo = $this->update[$this->messageType]['reply_to_message']['chat']['type']; //tipo della chat (utente, gruppo, canale) del messaggio a cui si sta rispondendo
        $this->reply_time = $this->update[$this->messageType]['reply_to_message']['date']; //data della chat a cui si stà rispondendo
        $this->reply_text = $this->update[$this->messageType]['reply_to_message']['text']; //testo del messaggio a cui si stà rispondendo
        $this->reply_entities = $this->update[$this->messageType]['reply_to_message']['entities']; //array delle entities del messaggio a cui si stà rispondendo
        if(isset($this->update[$this->messageType]['reply_to_message']['forward_from']['id'])){ //Se è presente una risposta ad un messaggio forwardato
          $this->chat_id_reply_forward = $this->update[$this->messageType]['reply_to_message']['forward_from']['id'];
          $this->is_bot_reply_forward = $this->update[$this->messageType]['reply_to_message']['forward_from']['is_bot'];
          $this->nome_reply_forward = $this->update[$this->messageType]['reply_to_message']['forward_from']['first_name'];
          $this->time_reply_forward = $this->update[$this->messageType]['reply_to_message']['forward_date'];
          $this->text_reply = $this->update[$this->messageType]['reply_to_message']['text'];
          if(isset($this->update[$this->messageType]['reply_to_message']['forward_from']['last_name'])){
            $this->cognome_reply_forward = $this->update[$this->messageType]['reply_to_message']['forward_from']['last_name'];
          } //Fine reply_forward
      } //Fine reply_to_message
      } else if(isset($this->update['inline_query']['id'])){ //Se è un inline_query
      $this->update_id = $this->update['update_id']; //update_id del inline_query
      $this->inline_id = $this->update['inline_query']['id']; //id del inline_query
      $this->inline_user_id = $this->update['inline_query']['from']['id']; //user_id dell'utente del inline_query
      $this->inline_is_bot = $this->update['inline_query']['from']['is_bot']; //is_bot dell'utente del inline_query
      $this->inline_nome = $this->update['inline_query']['from']['first_name']; //cognome dell'utente del inline_query
      if(isset($this->update['inline_query']['from']['last_name'])){
        $this->inline_cognome = $this->update['inline_query']['from']['last_name']; //cognome dell'utente del inline_query
      }
      $this->inline_username = $this->update['inline_query']['from']['username']; //username dell'utente del inline_query
      $this->inline_lingua = $this->update['inline_query']['from']['language_code']; //lingua dell'utente del inline_query
      $this->inline_query = $this->update['inline_query']['query']; //query dell'inline query
      $this->inline_offset = $this->update['inline_query']['offset']; //offset dell'inline query
    } //Fine inline_query
    } //Fine verifica messaggio
    } //Fine verifica json
    } //Fine __construct



  #FUNZIONI

  public function cURL($url){

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 6);
   curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
   curl_setopt($ch, CURLOPT_URL, $url);
   $output = curl_exec($ch);
   curl_close($ch);
   return json_decode($output, TRUE);

  }

  public function deleteMessage($user_id,$message_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/deleteMessage?chat_id=$user_id&message_id=$message_id";
    return $this->cURL($url);
  }

  public function deleteMessage2($user_id,$message_id){ #ATTENZIONE, può essere usato solo una volta nel file, e non restituisce alcun output

    header('Content-Type: application/json');

    $parameters = array(
      'chat_id' => $user_id,
      'message_id' => $message_id,
      'method' => 'deleteMessage'
    );

    echo json_encode($parameters, TRUE);

  }

  public function restrictChatMember($chat_id,$user_id,$perms = false, $until_date = false){

    if($until_date == false){
      $until_date = 0;
    }

    if($perms != false){
    $permessi = '&permissions='.http_build_query($perms);
    } else {
    $permessi = '';
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/restrictChatMember?chat_id=$chat_id&user_id=$user_id&until_date=$until_date".$permessi;
    return $this->cURL($url);
  }

  public function promoteChatMember($chat_id,$user_id,$perms = false){

    if($until_date == false){
      $until_date = 0;
    }


    if($perms != false){
      $permessi = '&permissions='.http_build_query($perms);
    } else {
      $permessi = '';
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/promoteChatMember?chat_id=$chat_id&user_id=$user_id".$permessi.'&until_date='.$until_date;
    return $this->cURL($url);
  }

  public function exportChatInviteLink($chat_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/exportChatInviteLink?chat_id=$chat_id";
    return $this->cURL($url);
  }

  public function unbanChatMember($chat_id,$user_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/unbanChatMember?chat_id=$chat_id&user_id=$user_id";
    return $this->cURL($url);
  }

  public function kickChatMember($chat_id,$user_id,$until_date = false){
    if($until_date == false){
      $until_date = 0;
    }
    $url = 'https://api.telegram.org/bot'.$this->bot."/kickChatMember?chat_id=$chat_id&user_id=$user_id&until_date=$until_date";
    return $this->cURL($url);
  }

  public function setChatTitle($user_id,$title){
    $url = 'https://api.telegram.org/bot'.$this->bot."/setChatTitle?chat_id=$user_id&title=$title";
    return $this->cURL($url);
  }

  public function setChatDescription($chat_id,$description = false){

    if($description == false){
      $description = '';
    } else {
      $description = '&description='.$description;
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/setChatDescription?chat_id=$chat_id".$description;
    return $this->cURL($url);
  }

  public function sendChatAction($user_id,$action){
    $url = 'https://api.telegram.org/bot'.$this->bot."/sendChatAction?chat_id=$user_id&action=$action";
    return $this->cURL($url);
  }

  public function forwardMessage($from_chat_id,$user_id,$message_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/forwardMessage?from_chat_id=$from_chat_id&chat_id=$user_id&message_id=$message_id";
    return $this->cURL($url);
  }

  public function sendMessage($user_id, $text, $keyboard = false, $type = false, $risposta = false, $forceReply = false, $notifica = false, $parse_mode = false, $disableWebPagePreview = true){

    if ($keyboard != false) {
        if ($type == 'fisica') {
            $rm = '&reply_markup={"keyboard":['.urlencode($keyboard).'],"resize_keyboard":true}';
        } else if($type == 'inline'){
            $rm = '&reply_markup={"inline_keyboard":['.urlencode($keyboard).'],"resize_keyboard":true}';
        }
    } else {
      $rm = '';
    }

    if($risposta == false){
      $risposta = '';
    } else {
      $risposta = '&reply_to_message_id='.$risposta;
    }

    if($parse_mode == false){
      $parse_mode = '&parse_mode=HTML';
    } else {
      $parse_mode = '&parse_mode='.$parse_mode;
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/sendMessage?chat_id=$user_id&text=" . urlencode($text) . $parse_mode . '&disable_web_page_preview=' . $disableWebPagePreview . $rm . $risposta . '&force_reply=' . $forceReply . '&disable_notification=' . $notifica . '&force_reply=' . $forceReply;
    return $this->cURL($url);
  }

  public function sendMessage2($user_id, $text, $keyboard = false, $type = false, $risposta = false, $forceReply = false, $notifica = false, $parse_mode = false, $disableWebPagePreview = true){ #ATTENZIONE, può essere usato solo una volta nel file, e non restituisce alcun output

    if ($keyboard != false) {
        if ($type == 'fisica') {
            $rm = '{"keyboard":['.$keyboard.'],"resize_keyboard":true}';
        } else if($type == 'inline'){
            $rm = '{"inline_keyboard":['.$keyboard.'],"resize_keyboard":true}';
        }
    } else {
      $rm = '';
    }

    if($parse_mode == false){
      $parse_mode = 'HTML';
    }

    header('Content-Type: application/json');

    $parameters = array(
      'chat_id' => $user_id,
      'method' => 'sendMessage',
      'disable_notification' => $notifica,
      'force_reply' => $forceReply,
      'reply_to_message_id' => $risposta,
      'reply_markup' => $rm,
      'parse_mode' => $parse_mode,
      'text' => $text,
      'disable_web_page_preview' => $disableWebPagePreview
    );

    echo json_encode($parameters, TRUE);

  }

  public function sendSticker($user_id,$sticker){
    $url = 'https://api.telegram.org/bot'.$this->bot."/sendSticker?chat_id=$user_id&sticker=$sticker";
    return $this->cURL($url);
  }

  public function sendPhoto($user_id, $photo, $caption = false, $keyboard = false, $type = false, $file_id = true){

    if ($keyboard != false) {
        if ($type == 'fisica') {
            $rm = '{"keyboard":['.$keyboard.'],"resize_keyboard":true}';
        } else if($type == 'inline'){
            $rm = '{"inline_keyboard":['.$keyboard.'],"resize_keyboard":true}';
        }
    } else {
      $rm = '';
    }

    if($caption == false){
      $caption = '';
    }

    $ch = curl_init();

    if($file_id == true){
      $args = [
        'caption' => $caption,
        'chat_id' => $user_id,
        'photo' => $photo,
        'reply_markup' => $rm,
        'parse_mode' => 'HTML'
      ];
    } else {
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:multipart/form-data']);
      $photoFile = new CURLFile($photo);
      $args = [
        'caption' => $caption,
        'chat_id' => $user_id,
        'photo' => $photoFile,
        'reply_markup' => $rm,
        'parse_mode' => 'HTML'
      ];
    }
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$this->bot.'/sendPhoto');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, TRUE);
    }

  public function sendAudio($user_id,$audio,$caption = false){

    if($caption == false){
      $caption = '';
    } else {
      $caption = '&caption='.urlencode($caption);
    }


    $url = 'https://api.telegram.org/bot'.$this->bot."/sendAudio?chat_id=$user_id&audio=".urlencode($audio).$caption;
    return $this->cURL($url);
    }

  public function sendVideo($user_id,$video,$caption = false){

    if($caption == false){
      $caption = '';
    } else {
      $caption = '&caption='.urlencode($caption);
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/sendVideo?chat_id=$user_id&video=$video".$caption;
    return $this->cURL($url);
    }

  public function sendMediaGroup($user_id,$album,$caption = false){

      if($caption == false){
        $caption = '';
      } else {
        $caption = '&caption='.urlencode($caption);
      }

    $url = 'https://api.telegram.org/bot'.$this->bot."/sendMediaGroup?chat_id=$user_id&media=$album".$caption;
    return $this->cURL($url);
  }

  public function sendDocument($user_id, $document, $file_id = true, $caption = false, $parse_mode = false){

    if($caption == false){
      $caption = '';
    }

    if($parse_mode == false){
      $parse_mode = 'HTML';
    }

    $ch = curl_init();

    if($file_id == true){
      $args = [
        'chat_id' => $user_id,
        'document' => $document,
        'caption' => $caption,
        'parse_mode' => $parse_mode
      ];
    } else {
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:multipart/form-data']);
      $document = new CURLFile($document);
      $args = [
        'chat_id' => $user_id,
        'document' => $document,
        'caption' => $caption,
        'parse_mode' => $parse_mode
      ];
    }

    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$this->bot.'/sendDocument');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, TRUE);
  }

  public function sendVoice($user_id,$voice,$caption = false){

    if($caption == false){
      $caption = '';
    } else {
      $caption = '&caption='.urlencode($caption);
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/sendVoice?chat_id=$user_id&voice=".urlencode($voice);
    return $this->cURL($url);
  }

  public function sendAnimation($user_id,$animation,$caption = false){

    if($caption == false){
      $caption = '';
    } else {
        $caption = '&caption='.urlencode($caption);
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/sendAnimation?chat_id=$user_id&animation=".urlencode($animation);
    return $this->cURL($url);
  }

  public function answerCallbackQuery($callback_query_id,$text,$show_alert = true){

    if($show_alert == true){
      $show_alert = '&show_alert=true';
    } else {
      $show_alert = '&show_alert=false';
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/answerCallbackQuery?callback_query_id=$callback_query_id&text=".urlencode($text).$show_alert;
    return $this->cURL($url);
  }

  public function editMessageText($user_id, $message_id, $newText, $keyboard = false, $type = false, $parse_mode = false, $disableWebPagePreview = true){

    if ($keyboard != false) {
        if ($type == 'fisica') {
            $rm = '&reply_markup={"keyboard":['.urlencode($keyboard).'],"resize_keyboard":true}';
        } else if($type == 'inline'){
            $rm = '&reply_markup={"inline_keyboard":['.urlencode($keyboard).'],"resize_keyboard":true}';
        }
    } else {
      $rm = '';
    }

    if($parse_mode == false){
      $parse_mode = 'HTML';
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/editMessageText?chat_id=$user_id&message_id=$message_id&text=".urlencode($newText) . '&disable_web_page_preview=' . $disableWebPagePreview . '&parse_mode=' . $parse_mode . $rm;
    return $this->cURL($url);
  }

  public function editMessageText2($user_id, $message_id, $newText, $keyboard = false, $type = false, $parse_mode = false, $disableWebPagePreview = true){

    if ($keyboard != false) {
        if ($type == 'fisica') {
            $rm = '{"keyboard":['.$keyboard.'],"resize_keyboard":true}';
        } else if($type == 'inline'){
            $rm = '{"inline_keyboard":['.$keyboard.'],"resize_keyboard":true}';
        }
    } else {
      $rm = '';
    }

    if($parse_mode == false){
      $parse_mode = 'HTML';
    }

    header('Content-Type: application/json');

    $parameters = array(
      'chat_id' => $user_id,
      'message_id' => $message_id,
      'method' => 'editMessageText',
      'parse_mode' => $parse_mode,
      'text' => $newText,
      'disable_web_page_preview' => $disableWebPagePreview,
      'reply_markup' => $rm
    );

    echo json_encode($parameters, TRUE);

  }

  public function leaveChat($chat_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/leaveChat?chat_id=$chat_id";
    return $this->cURL($url);
  }

  public function leaveChat2($chat_id){

    header('Content-Type: application/json');

    $parameters = array(
      'chat_id' => $user_id,
      'method' => 'leaveChat'
    );

    echo json_encode($parameters, TRUE);

  }

  public function pinChatMessage($chat_id,$message_id,$disable_notification = false){

    if($disable_notification == false){
      $disable_notification = '&disable_notification=false';
    } else {
      $disable_notification = '&disable_notification=true';
    }

    $url = 'https://api.telegram.org/bot'.$this->bot."/pinChatMessage?chat_id=$chat_id&message_id=$message_id&disable_notification=$disable_notification";
    return $this->cURL($url);
  }

  public function getChat($chat_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/getChat?chat_id=$chat_id";
    return $this->cURL($url);
  }

  public function deleteWebhook($token = false){

    if($token == false){
      $url = 'https://api.telegram.org/bot'.$this->bot.'/deleteWebhook';
    } else {
      $url = 'https://api.telegram.org/bot'.$token.'/deleteWebhook';
    }

    return $this->cURL($url);
  }

  public function setWebhook($token = false, $url = false, $max_connections = false){

    if($max_connections == false){
      $max_connections = '&max_connections=40';
    } else {
      $max_connections = '&max_connections='.$max_connections;
    }

    if($url == false){
      $url = '';
    }

    if($token == false){
      $url = 'https://api.telegram.org/bot'.$this->bot.'/setWebhook?url='.$url.$max_connections;
    } else {
      $url = 'https://api.telegram.org/bot'.$token.'/setWebhook?url='.$url.$max_connections;
    }

    return $this->cURL($url);
  }

  public function getWebhookInfo($token = false){

    if($token == false){
      $url = 'https://api.telegram.org/bot'.$this->bot.'/getWebhookInfo';
    } else {
      $url = 'https://api.telegram.org/bot'.$token.'/getWebhookInfo';
    }

    return $this->cURL($url);
  }

  public function getChatAdministrators($chat_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/getChatAdministrators?chat_id=$chat_id";
    return $this->cURL($url);
  }

  public function getChatMembersCount($chat_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/getChatMembersCount?chat_id=$chat_id";
    return $this->cURL($url);
  }

  public function getChatMember($chat_id, $user_id){
    $url = 'https://api.telegram.org/bot'.$this->bot."/getChatMember?chat_id=$chat_id&user_id=$user_id";
    return $this->cURL($url);
  }

  public function gestisciInlineQuery($inlineData,$switchText = false,$switchParameter = false, $cacheTime = false){

             if($switchText == false){
               $switchText = 'Ritorna al bot';
             }

             if($switchParameter == false){
               $switchParameter = 123;
             }

             if($cacheTime == false){
               $cacheTime = 0;
             }

             $risultati = json_encode($inlineData,true);
             $url = 'https://api.telegram.org/bot'.$this->bot."/answerInlineQuery?inline_query_id=$this->inline_id&results=$risultati&cache_time=$cacheTime&switch_pm_text=$switchText&switch_pm_parameter=$switchParameter";
             return $this->cURL($url);

             # ESEMPIO DI OGGETTO INLINE

             /*
             $inlineData=[[
                 "type" => "article",
                 "id" => "0 (sarà il primo risultato, se fosse stato 2 appariva dopo l'1 e lo 0, e così via)",
                 "title" => "Titolo qua",
                 "input_message_content" => array("message_text" => "Quello che ti pare", "parse_mode" => "HTML (o altro)"),
                 "reply_markup" => array("inline_keyboard" => [[array("text" => "TESTO DEL PULSANTE INLINE","url (o callback_data)" => "URL o Callback data")]]),
                 "description" => "Qua la tua descrizione"
              ],
              [
                  "type" => "article",
                  "id" => "1",
                  "title" => "Titolo qua 2",
                  "input_message_content" => array("message_text" => "Quello che ti pare 2", "parse_mode" => "HTML (o altro)"),
                  "reply_markup" => array("inline_keyboard" => [[array("text" => "TESTO DEL PULSANTE INLINE 2","url (o callback_data)" => "URL o Callback data")]]),
                  "description" => "Qua la tua descrizione 2"
               ]
               ];

              */


  }

} //Fine della classe

?>
