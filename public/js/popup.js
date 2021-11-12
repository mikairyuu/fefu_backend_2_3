function popup(ok_route){
    //check if using cached data
    if(window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD)
        return;
    let result = confirm("Do you mind leaving your feedback?");
    if(result){
        let url = new URL(ok_route);
        url.searchParams.append('suggested', '1');
        window.location.replace(url);
    }
}
