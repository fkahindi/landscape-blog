$("document").ready(function() {
    "use strict";
    var email_state = false;
    /**
     * Scripts to manage subscription form
     */
    $("#email").on("blur", function() {
        var email = $("#email").val();
        var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/; /* Check if it's valid mail address */
        var illegalChars = /[\(\)<>\,\;\:\\\"\[\]]/; /* Check for illegal characters */
        if (email === "") {
            email_state = false;
            return;
        }
        /* Further email validation */
        if (!emailFilter.test(email)) {
            email_state = false;
            $("#email").parent().removeClass();
            $("#email").parent().addClass("form-error");
            $("#email").siblings("span").text("Check! Email address not valid.");
        } else if (email.match(illegalChars)) {
            email_state = false;
            $("#email").parent().removeClass();
            $("#email").parent().addClass("form-error");
            $("#email").siblings("span").text("Sorry... Email address contains illegal characters");
        } else {
            email_state = true;
            $("#email").parent().removeClass();
            $("#email").parent().addClass("form-success");
            $("#email").siblings("span").text("");
            $("#subscribe-error").text("");
        }
    });

    $("#subscribe-btn").on("click", function(e) {

        var email = $("#email").val();

        e.preventDefault();

        if (email === "") {
            $("#email").parent().removeClass();
            $("#email").parent().addClass("form-error");
            $("#email").siblings("span").text("Enter your email address, first.");
            return;
        }
        if (email_state === false) {
            $("#subscribe-error").text("Fix errors in the form, first");

        } else {
            $.ajax({
                url: "/landscape/includes/subscribeFormFunctions.php",
                type: "POST",
                data: {
                    "subscribe": 1,
                    "email": email,
                },
                success: function(response) {

                    $("#subscribe_response").append(response);

                    $("#email").val("");
                    $("#subscribe-error").text("");
                }
            });
        }
    });
    /*
     *	Scripts to manage user comments on articles
     * Using the parent comments-container for events delegation
     */
    $("#comments-container").on("click", [".submit_comment", ".post_reply", ".reply-btn", ".reply-thread", ".load-more"], function(e) {
        e.preventDefault();
        var target = e.target;
        var comment_id = parseInt(target.id.match(/\d+/));
        switch (target.className.toLowerCase()) {
            case "submit_comment":
                submitComment();
                break;
            case "reply-btn":
                showReplyForm(comment_id);
                break;
            case "post_reply":
                postReply(comment_id);
                return false;
            case "reply-thread":
                displayReplyThread(comment_id);
                break;
            case "load-more":
                loadMoreComments();
                break;
            default:
                /* do nothing */
        }
    });

    function submitComment() {
        var user_id = $("#user_id").val();
        var page_id = $("#page_id").val();
        var comment = $("#comment").val();

        $("#comment").val("");

        if (comment === "") {
            return false;
        }
        $.ajax({
            url: "/spexproject/includes/comments_functions.php",
            type: "POST",
            data: {
                "submit_comment": 1,
                "user_id": user_id,
                "page_id": page_id,
                "body": comment,
            },
            success: function(response) {

                $("#comments-area").prepend(response);

                comment = "";
            }
        });
    }
    /*
     * Scripts to manage replies to comments on articles
     * When user clicks reply link to add a reply under user's comment */
    function showReplyForm(comment_id) {

        $("form#comment_reply_form_" + comment_id).toggle(100);

        $("#reply_btn_" + comment_id).text($("#reply_btn_" + comment_id).text() == "Reply" ? "Cancel" : "Reply");
    }

    /*Posting a reply */
    function postReply(comment_id) {
        var reply_textarea = $("#post_reply_" + comment_id).siblings(".reply-textarea");
        var reply_text = $("#post_reply_" + comment_id).siblings("#reply_textarea_" + comment_id).val();
        var user_id = $("#post_reply_" + comment_id).siblings(".reply_form_user_id").val();

        reply_textarea.val("");

        if (reply_text === "") {
            return false;
        }
        $.ajax({
            url: "/spexproject/includes/comments_functions.php",
            type: "POST",
            data: {
                "post_reply": 1,
                "user_id": user_id,
                "comment_id": comment_id,
                "reply_text": reply_text
            },
            success: function(data) {

                $(".replies_container_" + comment_id).children(".replies_by_ajax").prepend(data);

                $("form#comment_reply_form_" + comment_id).hide();
                $("#reply_btn_" + comment_id).text("Reply");
                $(".group.replies_container_" + comment_id).show(100);
                comment_id = "";
            }
        });
    }
    /* When user clicks Replies link replies of that comment are displayed */
    function displayReplyThread(comment_id) {
        var thread_reply_id = comment_id;
        var html1 = "&#9650;";
        var html2 = "&#9660;";

        $(".group.replies_container_" + thread_reply_id).toggle(100);

        $("#reply_thread_" + comment_id).text($("#reply_thread_" + comment_id).text() == convertEntities(html1) ? convertEntities(html2) : convertEntities(html1));
    }
    /* When user clicks Load more... */
    function loadMoreComments() {
        var page_id = $(".pagination").data("id");
        var page_no = $(".load-more").data("id");
        var no_of_comments_per_view = $(".comments-per-view").data("id");
        var number_of_pages = $("#num-of-pages").data("id");
        var offset = 0;
        var limit = "";

        if (page_no !== 0) {
            offset = (page_no - 1) * no_of_comments_per_view;
        } else {
            return false;
        }
        limit = "LIMIT " + offset + ", " + no_of_comments_per_view;

        $.ajax({
            url: "/spexproject/includes/comments_functions.php",
            type: "POST",
            data: {
                "load_more": 1,
                "page_id": page_id,
                "limit": limit
            },
            success: function(data) {

                page_no = page_no + 1;
                $("#comments-area").append(data);

                $(".load-more").data("id", page_no);
                window.scrollBy(0, window.innerHeight);
                if (page_no > number_of_pages) {
                    $(".load-more").hide();
                }
            }
        });
    }

    function convertEntities(html) {
        var el = document.createElement("div");
        el.innerHTML = html;
        return el.firstChild.data;
    }
});