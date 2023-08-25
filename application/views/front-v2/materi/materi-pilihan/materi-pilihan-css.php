<style>
    canvas {
        display: block;
    }

    /*
    ==========
    ==========
    KUIS
    ==========
    ==========
    */

    .list-group-item {
        user-select: none;
        padding: 10px 0;
        margin: 0;
        background: none !important;
        color: black !important;
    }

    .list-group input[type="checkbox"] {
        display: none;
    }

    .list-group input[type="checkbox"] + .list-group-item {
        cursor: pointer;
    }

    .list-group input[type="checkbox"]:checked + .list-group-item {
        background-color: #f8f9fa;
    }

    .list-group input[type="checkbox"]:checked + .list-group-item:before {
        color: inherit;
    }

    .list-group input[type="radio"] {
        display: none;
    }

    .list-group input[type="radio"] + .list-group-item {
        cursor: pointer;
    }

    .kuis-radio {
        display: inline-block;
        border: 2px solid #EBEAEB;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        padding: 10px 12.5px;
        /*margin-right:30px;*/
        font-weight: bold;
    }

    .list-group input[type="radio"]:checked + .list-group-item .kuis-radio {
        border: 2px solid #E8225A;
        color: #E8225A;
    }

    .list-group input[type="radio"]:checked + .list-group-item {
        font-weight: bold;
    }

    .list-group input[type="radio"]:checked + .list-group-item:before {
        color: inherit;
    }

    #kuis-detik {
        font-family: "Roboto";
        width: max-content;
        padding: 10px 12.5px;
        border-radius: 50rem;
        user-select:none;
    }

    #kuis-nilai {
        font-size: 16px;
        font-weight: bolder;
        position: absolute;
        top: 50.3%;
        left: -4%;
        text-align: center;
        margin: 0 auto;
        width: 100%;
        user-select:none;
    }

    .sweet-alert .btn {
        margin-top: 1em;
    }
</style>
