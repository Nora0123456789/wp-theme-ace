



console.log( "blocks frontend loaded." );

var classActive = "is-active";   

// Tabs
var initTabBlocks = () => {
    
    var blockTabsList = document.querySelectorAll( '.tab-list' );
    var tabMenuItems = document.querySelectorAll( '.tab-menu-item' );

    console.dir( blockTabsList );
    console.dir( tabMenuItems );

    blockTabsList.forEach( function( blockTabs, index ) {

        var blockTabMenuItemButtons = blockTabs.querySelectorAll( '.tab-button' );
        console.dir( blockTabMenuItemButtons );

        blockTabMenuItemButtons[0].parentElement.classList.add( classActive );
        if ( 'undefined' === typeof tabMenuItems[0] ) {
            return;
        }
        tabMenuItems[0].classList.add( classActive );

        blockTabMenuItemButtons.forEach( function( currentButton, buttonIndex ) {

            currentButton.addEventListener( 'click', function( eventClick ) {

                blockTabMenuItemButtons.forEach( function( eachButton, eachButtonIndex ) {
                    eachButton.parentElement.classList.remove( classActive );
                } );

                tabMenuItems.forEach( function( eachMenuItem, eachMenuItemIndex ) {
                    eachMenuItem.classList.remove( classActive );
                } );

                currentButton.parentElement.classList.add( classActive );

                tabMenuItems[ buttonIndex ].classList.add( classActive );

                //setTimeout( () => document.dispatchEvent( new Event( 'aceDidSwitchBlockTab', { "bubbles": false, "cancelable": false } ) ), 0 );

            });

        } );

    });

};

document.addEventListener( 'DOMContentLoaded', initTabBlocks );