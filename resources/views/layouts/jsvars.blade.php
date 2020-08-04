@if (Internet::conneted())
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBfY6ipJn-hvZ6O6VndRfp8yI9nOYovsuM" type="text/javascript">
</script>
<script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
    window.pusher = new Pusher('{{env("PUSHER_APP_KEY")}}',{
        cluster: '{{env("PUSHER_APP_CLUSTER")}}',
        forceTLS: true
    });
</script>
@endif
<style>
    #media-list li img {
        width: 100px;
        height: 100px;
        object-fit: cover
    }

    #media-list li video {
        width: 100px;
        position: relative;
        left: 0;
        right: 0;
        top: 50%;
        transform: translateY(-50%)
    }

    div#hint_brand .modal-dialog {
        top: 110px;
        width: 567px;
        max-width: 100%
    }

    ul#media-list div.loading {
        position: relative;
        width: 100px;
        height: 100px;
        box-sizing: border-box;
        display: inline-block;
    }

    ul#media-list div.load-img {
        width: 100px;
        height: 100px;
        background-image: url(data:image/gif;base64,R0lGODlhEAAQAPIEAPP1+fP2+fT2+ff5+////wAAAAAAAAAAACH5BAUIAAQAIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAAQAAADPUi63P4wLiAEUNTiSscQiuCBhPiZpHkRwNh+2Bif3oqGrszWsznYngHu90rxSjkY8je0AJ4bDYsjqVqvigQAIfkEBQgAAgAsAAADAAQACwCB8/X58/b5////AAAAAgiEIanL7X9AAQAh+QQJCAAJACwAAAAACgAQAIOBlb6GmsGHm8GwvNaxvdbx9Pfz9fjz9fn19/r///8AAAAAAAAAAAAAAAAAAAAAAAAENBAIAZK9ghBx8dhXURjCMHCJgSAGYKJdeXaWXNEy7M20y8cvWiInlAUsKpYtNMqAepNbJwIAIfkECQgAEAAsAAAAABAAEACEgZW+hprBh5vBipzCl6fIoa/OobDOsLzWsb3WuMLZwcrdwcre8fT38/X48/X59ff6////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABVsgMQwEBAGCAJgsZCSJYQrHIbRmsSzFXN8mBsOh4/lsJsfjQdzJIDQkrviMAluFxKL6w0GoxyvrZYR2cYZd71RbodVhb7pslTvjECVzvq4Hhy8xeC0iJCYoKl4hACH5BAkIABAALAAAAAAQABAAhIGVvoaawYebwYqcwpenyKGvzqGwzrC81rG91rjC2brE2sHK3cHK3srS49HY5tHY5////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAVqICSOxDAQIiAIwDgaSWKIAoIIStMoYrEsBVHggAgoHg8exLeYQYbFo0PJDD4PB+Nj2vtZh1mFg7v0CrHGMdV8Dau7wLObXBUi3En4Fy3OQwxsYFp+dW1GOmtxhi4iMDI0NgGMECUnKSsAIQAh+QQJCAARACwAAAAAEAAQAISKnMKXp8ihr86hsM64wtm6xNrByt3Byt7K0uPR2ObR2Ofj6PDm6vHo7PPp7PPt8fbv8vf///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFY2AkjqQYAEBQrtFAEIO4jAWCFKJwHIPzPA5RQaHARXQHgQ/SEBKNyEADwnQWc7vBtBoZXlvZbbP7FA3C1LEXuhOIrezkm5wwng/StLNuDjceamVgPAyFNDZ2WSwlLjCLJCcpIQAh+QQJCAAMACwAAAAAEAAQAIO6xNrK0uPR2ObR2Ofj6PDo7PPp7PPs7vTs7/Xt8fbv8vfy9Pj///8AAAAAAAAAAAAEWpDJSau9eBIyQQjAkRyHZCSJIQHDEC5LYirp2gIJXDKGsqgMluC12PUShZVgeIDJeL5kcInTSQo0KcvVLF4VCu2t+8SGlcOcl2HWUkkjEwq4BVw2nY89w+8zIgAh+QQJCAANACwAAAAAEAAQAIPj6PDm6vHo7PPp7PPs7vTs7/Xt8fbv8vfy9Pjz9fnz9vn09vn3+fv///8AAAAAAAAEWbDJSau9OAOZ1koSQRiENBjGsDDMEiZJ2QwIubYhkhgmKiQsV8OAQMgEhwPhBmoQYMeD4RfMGUPJJav5jEkCycBN+Lw2kAfB+GVG/zxc0hEly0gAgIB9v48AACH5BAUIAAcALAAAAAAQABAAguzu9Ozv9fL0+PP1+fP2+fT2+ff5+////wNFeLrc/jCuUcpQ1CoQAiiGUSigqASD8IXjUV4HOgADi9kHIMwvieuzmskVgqFUPeJQthqWWjok7rkZBCuwDJQDkHi/YEUCACH5BAQUAAAALAwAAwAEAAoAAAIOhGQzpwCKoGhzvVXRAQUAOw==);
        background-position: 50%;
        background-repeat: no-repeat;
        box-sizing: border-box;
        display: inline-block;
        position: absolute;
    }


    ul#media-list div.loading .spinner-img {
        width: 100px;
        height: 100px;
        background-image: url(data:image/png;base64,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);
        background-position: 50%;
        background-repeat: no-repeat;
        box-sizing: border-box;
        display: inline-block;
        position: absolute;
        animation: rotation .6s infinite linear;
    }

    li.myupload span {
        position: relative;
        width: 100px;
        height: 100px;
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OUM2MEREN0U1MTY4MTFFNDhGN0JFREYwMDUwRTVDNTYiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OUM2MEREN0Q1MTY4MTFFNDhGN0JFREYwMDUwRTVDNTYiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkU1MUFGMDk5MUQ0RTExRTI4MjRFREE5REY3NkFEMUZGIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU1MUFGMDlBMUQ0RTExRTI4MjRFREE5REY3NkFEMUZGIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+bUQWGQAAADlJREFUeNpi/P//PwM+cO/ePRQFSkpKjPjUMzFQGYwaOBIMZLx79+7/0TCkLAxH8/KogYPAQIAAAwDT3BG2rX7OWwAAAABJRU5ErkJggg==);
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: 20px;
        /* border: 2px dashed #dddfe2; */
        border-radius: 2px;
        box-sizing: border-box;
        display: inline-block;
    }

    li.myupload span label {
        width: 100px;
        height: 100px;
        margin-bottom: 0;
        position: absolute;
    }

    li.myupload span label input {
        opacity: 0;
        visibility: hidden;
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100px;
        height: 100px;
    }

    li.myupload span i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #ccc;
        font-size: 54px
    }

    #media-list li {
        float: left;
        position: relative;
        margin: 1px;
        height: 100px;
        width: 100px;
        border: 1px solid #ccc;
    }


    .post-thumb {
        position: absolute;
        background: rgba(0, 0, 0, 0.4);
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        height: 100px;
        width: 100px;
        display: none
    }

    #media-list li:hover .post-thumb {
        display: block
    }

    a.remove {
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 12px;
        color: #fff;
        display: block;
        height: 25px;
        width: 25px;
        text-align: center;
        padding: 3px 0;
        opacity: .8;
    }

    a.remove:hover {
        opacity: 1;
    }

    .inner-post-thumb {
        position: relative
    }

    ul#media-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: inline-flex;
        overflow-y: hidden;
        overflow-x: auto;
        width: 100%;
    }
</style>
