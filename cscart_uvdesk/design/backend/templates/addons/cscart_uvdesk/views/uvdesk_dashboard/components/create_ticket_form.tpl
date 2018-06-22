<div class="ty-custom_fields">
        <form action="{""|fn_url}" method="post" name="forms_{$id}" enctype="multipart/form-data">
            <input type="hidden" value="{$c_url}" name="redirect_url">
            <div class="ty-control-group">
                <label class="cm-required" for="elm_id_cn" style="float:left;">{__("customer_name")}:</label>
                <input type="text" name="customer_name" value="" id="elm_id_cn" style="width:95%;" />
            </div>
            <div class="ty-control-group">
                <label class="cm-email cm-required" for="elm_id_cf" style="float:left;">{__("customer_email")}:</label>
                <input type="text" name="customer_email" value="" id="elm_id_cf" style="width:95%;" />
            </div>
            <div class="ty-control-group">
                <label class="cm-required" for="elm_id_tt" style="float:left;">{__("ticket_type")}:</label>
                <select name="ticket_type" id="elm_id_tt" style="width:95%;">
                    <option value="" selected>Choose Ticket Type</option>
                    {foreach from=$types item=type}
                        <option value="{$type.id}">{$type.name}</option>
                    {/foreach}
                </select>
            </div>
            <div class="ty-control-group">
                <label class="cm-required" for="elm_id_ts" style="float:left;">{__("ticket_subject")}:</label>
                <input type="text" name="ticket_subject" value="" id="elm_id_ts" style="width:95%;"/>                
            </div>
            <div class="ty-control-group">
                <label class="cm-required" for="elm_id_tm" style="width: 17%;">{__("ticket_message")}:</label>
                <textarea id="elm_id_tm" name="ticket_message" cols="55" rows="2" class="cm-wysiwyg input-large" style="resize: none;width: 90%"></textarea>
            </div>
            <div class="ty-control-group">
				<div class="form-group ">
					<div class="">
                        <span class="btn btn-success fileinput-button">
                        <span>Select file</span>
					    <input id="attachments" name="attachments[]" infolabel="right" infolabeltext="+ Attach File" decoratefile="decorateFile" decoratecss="attach-file" enableremoveoption="enableRemoveOption" multiple="true" class="fileHide" type="file">
				    </div>
				</div>
			</div>
            <span id="filelist" style="display:none;"></span>
            <div class="ty-custom_fields__buttons buttons-container">
                {include file="buttons/save_cancel.tpl" but_text=__("create_ticket") but_name="dispatch[uvdesk_dashboard.create_ticket]" cancel_action="close"  but_role="submit" but_meta="cm-process-items"}
            </div>
        </form>
</div>

<script>
document.getElementById('attachments').addEventListener('change', function(e) {
  var list = document.getElementById('filelist');
  list.innerHTML = '';
  for (var i = 0; i < this.files.length; i++) {
    list.innerHTML += this.files[i].name + ', \n';
  }
  if (list.innerHTML == '') list.style.display = 'none';
  else list.style.display = 'block';
});
</script>