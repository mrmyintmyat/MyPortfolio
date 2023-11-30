$(document).ready(function() {
    //search
    let check_search = false;
    let input_val;
    let searchnogames = false
    $('#searchForm').submit(function(e) {
        e.preventDefault();
    })
    $('#search').keyup(function(e) {
        searchnogames = false;
        var query = $(this).val();
        input_val = query;
        var inputLength = query.length;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (inputLength != 0) {
            $.ajax({
                type: 'POST',
                url: '/search',
                data: {
                    _token: csrfToken,
                    query: query
                },
                beforeSend: function() {
                    $('#item_container_search').empty();
                    // $('.search_scroll_page').hide();
                    $('.search_scroll_page').show();
                    $('.scroll_page').hide();
                    $('.game_detail_hide').hide();
                    $('.search-error-message').hide();
                    $('.search-auto-load').show();
                },
                success: function(data) {
                    if (data.html.length > 0) {
                        $('.search_scroll_page').show();
                        $('.search-auto-load').hide();
                        $('.search-error-message').hide();
                        var searchResultsDiv = $('#item_container_search');
                        searchResultsDiv.empty();
                        searchResultsDiv.append(data.html);
                    } else {
                        // No more games available
                        // $('.search_scroll_page').hide();
                        var searchResultsDiv = $('#item_container_search');
                        searchResultsDiv.empty();
                        $('.search-error-message').html(
                            `<div class=" text-info"><i class="fa-solid fa-magnifying-glass fa-spin fa-spin-reverse me-2"></i>No more games found</div> `
                            );
                        $('.search-error-message').show();
                        $('.search-auto-load').hide();
                        searchnogames = true;
                    }

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }else{
            $('.search_scroll_page').hide();
            $('.search-error-message').hide();
            $('.scroll_page').show();
            $('.game_detail_hide').show();
        }

    });
    //scroll get item
    // var route = "/";
    var nextPage = 2;
    var search_nextPage = 2;
    var isLoading = false; // Track whether data is being loaded
    let nomoreitems = false;
    // Function to load more games
    function loadMoreItems(route) {
        if (isLoading) {
            return;
        }

        isLoading = true;
        // $('#loadingIndicator').show();

        $.ajax({
            type: 'GET',
            url: route,
            data: {
                page: nextPage,
                search_nextPage: search_nextPage,
                query: input_val
            },
            beforeSend: function() {
                $('.auto-load').show();
                $('.error-message').hide();
                $('.search-auto-load').show();
                $('.search-error-message').hide();
                // $(".main").scrollTop($(".main")[0].scrollHeight);
                // $(window).scrollTop($(document).height()); // Scroll to the bottom of the page

            },
            success: function(response) {
                if (response.length > 0) {
                  setTimeout(() => {
                    $('.auto-load').hide();
                $('.search-auto-load').hide();
                    $('#item_container').append(response);
                    nextPage++;
                    isLoading = false;
                  }, 1500);
                } else if(check_search && response.html.length > 0){
                  setTimeout(() => {
                        $('.auto-load').hide();
                        $('.search-auto-load').hide();
                        $('#item_container_search').append(response.html);
                        search_nextPage++;
                        isLoading = false;
                        check_search = false;
                  }, 1500);
                } else {
                    // No more games available
                    setTimeout(() => {
                    $('.error-message').html(
                        `<div class=" text-info"><i class="fa-solid fa-magnifying-glass mb-2 me-2"></i>No more games</div> `
                        );
                        $('.search-error-message').html(
                            `<div class=" text-info"><i class="fa-solid fa-magnifying-glass mb-2 me-2"></i>No more games</div> `
                            );
                    $('.error-message').show();
                    $('.search-error-message').show();
                    $('.auto-load').hide();
                $('.search-auto-load').hide();
                    nomoreitems = true;
                    isLoading = false;
                    check_search = false;
                }, 1500);
                }
            },
            error: function(xhr, status, error) {
                // console.log(error);
                isLoading = false;
                $('.auto-load').hide();
        $('.search-auto-load').hide();
            }
        });
    }

    // Detect scroll event
    $(".scroll_page").scroll(
        function() {
            on_scroll(this, "/");
        });

    $(".search_scroll_page").scroll(
        function() {
            on_scroll(this, "/search");
        });

     function on_scroll(element, route) {
        var mainElement = $(element);
        var scrollTop = mainElement.scrollTop();
        var scrollHeight = mainElement.prop("scrollHeight");
        var clientHeight = mainElement.height();
        // console.log(scrollTop + clientHeight + 50)
        // console.log(scrollHeight)


        // Internet connection available, proceed with loading more games
        if (scrollTop + clientHeight + 49 >= scrollHeight) {
            if (navigator.onLine) {
                if (route === "/search" && searchnogames === false) {
                    check_search = true;
                    loadMoreItems(route);
                } else if(nomoreitems === false){
                    loadMoreItems(route);
                }
            } else {
                // No internet connection, display error message
                // Show error message to the user
                $(".error-message").html(`<div class=" text-danger">
<i class="fa-solid fa-triangle-exclamation fa-fade"></i>Connection Error
</div> `);
                $(".error-message").show();
                // $(".main").scrollTop($(".main")[0].scrollHeight);
                // $(window).scrollTop($(document).height()); // Scroll to the bottom of the page

            }
        }
        // loadMoreItems();

    };
});
