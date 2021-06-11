// on click to open the modal, hydrate its dialog on the member Viral Banner set up page.
// $(".viralBannerModal").on("shown", function () {

$(".edit, .add").on("click", function () {

  // *** Get the Viral Banner array from the data-banner attribute of the clicked banner.
  const bannerArray = JSON.parse(($(this).attr('data-banner')));

  const showinmodal = bannerArray.showinmodal ?? "";
  const bannerslot = bannerArray.bannerslot ?? "";
  const id = bannerArray.id ?? "";
  const name = bannerArray.name ?? "";
  const alt = bannerArray.alt ?? "";
  const url = bannerArray.url ?? "";
  const imageurl = bannerArray.imageurl ?? "";
  const hits = bannerArray.hits ?? "";
  const clicks = bannerArray.clicks ?? "";

  switch (showinmodal) {
    case "add":
        $("#addbannerslot").html(bannerslot);
        $('#addname').val(name);
        $('#addalt').val(alt);
        $('#addurl').val(url);
        $('#addimageurl').val(imageurl);
        $('#addbannerpageslot').val(bannerslot);
      break;

    case "edit":
        $('#editform').attr('action', '/viralbanners/' + id);
        $('#deleteform').attr('action', '/viralbanners/' + id);
        $("#editbannerslot").html(bannerslot);
        $('#editname').val(name);
        $('#deletename').val(name);
        $('#editalt').val(alt);
        $('#editurl').val(url);
        $('#editimageurl').val(imageurl);
        $('#editbannerpageslot').val(bannerslot);
        $('#edithits').val(hits);
        $('#editclicks').val(clicks);
      break;

    case "upgradeproandgold":
      break;

    case "upgradegold":
      break;

    case "paidonly":
      break;

    default:

  }
  
});
