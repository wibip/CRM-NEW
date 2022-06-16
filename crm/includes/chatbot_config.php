<div class="control-group">
    <div class="controls form-group">
        <label class="" for="radiobtns">Chatbot Support <img data-toggle="tooltip" title="Turn on the chatbot to enable the capability to provide the user access to a set of questions and answers about this service. The Q&A is specific for this property and has to be set up in the chatbot system prior to being enabled here. Once enabled add the specific URL provided to you in the field below." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>
        <input onchange="setChatbot()" id="chatbot_support" name="chatbot_support" type="checkbox" data-size="mini" <?php if ($chatbot_support == "on") { ?> checked <?php } ?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning">
    </div>
</div>

<div class="control-group chatbot_url">
    <div class="controls form-group">
        <label class="" for="radiobtns">Chatbot URL<img data-toggle="tooltip" title="Only add the URL that corresponds to the chatbot created for this property." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>
        <input id="chatbot_url" name="chatbot_url" type="text" placeholder="" class="span6" value="<?php echo $chatbot_url; ?>">
    </div>
</div>
<script> 
    function setChatbot(){
        $('.chatbot_url, .chatbot_url_d').toggle();
    }
</script>
<?php if ($chatbot_support == "on") { ?>
<style>
.chatbot_url{
    display: block;
}
.chatbot_url_d{
    display: none
}
</style>
<?php }else{ ?>
    <style>
.chatbot_url{
    display: none;
}
</style>
    <?php } ?>