const resetForm = (element) => {
    $(element).trigger("reset");
};

function loadElement(element, bool) {
    $(element).prop("disabled", bool);
    let $this = $(element);
    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i>';
    if (bool) {
        $this.data("original-text", $($this).html());
        $this.html(loadingText);
    } else {
        $this.html($this.data("original-text"));
    }
}

const toggleAble = (element, bool, text) => {
    $(element).prop('disabled', bool);
    let $this = $(element);
    if (bool) {
        var loadingText = `<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> ${text || ' loading... '}`;
        $this.data('original-text', $($this).html());
        $this.html(loadingText);
    }else{
        $this.html($this.data('original-text'))
    }
}

const divLoader = () =>
    `<style>
  #circle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
  	width: 150px;
      height: 150px;
  }

  .loader {
      width: calc(100% - 0px);
  	height: calc(100% - 0px);
  	border: 8px solid #162534;
  	border-top: 8px solid #09f;
  	border-radius: 50%;
  	animation: rotate 5s linear infinite;
  }

  @keyframes rotate {
  100% {transform: rotate(360deg);}
  }
  </style>
  <div id="circle">
    <div class="loader">
      <div class="loader">
          <div class="loader">
             <div class="loader">

             </div>
          </div>
      </div>
    </div>
  </div> `;

const poster = ({ url, data, alert, type }, fn) => {
    alert = alert || true;
    type = type || "POST";
    $.ajax({ url, data, type })
        .done((res) => {
            if (res.status == true) {
                Swal.fire({
                    title: "Success!",
                    text: "Success! " + res.test + "",
                    icon: "success",
                    confirmButtonColor: "#556ee6",
                });
            } else {
                Swal.fire({
                    title: "Oops!",
                    text: " Sorry! " + res.text + "",
                    icon: "error",
                    confirmButtonColor: "#556ee6",
                });
            }
        })
        .fail((e) => {
            console.log(e);
            Swal.fire({
                title: "Oops!",
                text: "There was a server error",
                icon: "question",
                confirmButtonColor: "#556ee6",
            });
        });
};
