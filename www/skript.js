$(function(){
$('#formId').submit(function(e){
//�������� ����������� �������� ��� �������� �����
e.preventDefault();
//����� �� ����� ����� �������� ������
var m_method=$(this).attr('method');
//�������� ����� ������� �� �������, ���� ����� ��������� �����
var m_action=$(this).attr('action');
//�������� ������, ��������� ������������� � ������� input1=value1&input2=value2...,
//�� ���� � ����������� ������� �������� ������ �����
var m_data=$(this).serialize();
$.ajax({
type: m_method,
url: m_action,
data: m_data,
success: function(result){
$('#test_form').html(result);
}
});
});
});

function mail_valid() {
    var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    var form_mail = document.getElementById('mail');
    if (form_mail.value.search(mail)!==-1){
       alert('�����!!!'); 
    }
    else{
        alert("������ ���� ���� �����!");
    }
        
}