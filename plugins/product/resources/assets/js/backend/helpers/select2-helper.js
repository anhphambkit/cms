// Format icon
window.iconFormat = function(icon) {
    if (!icon.id) return icon.text;
    let imageFeature = '/vendor/core/images/default-avatar.jpg';
    if (icon.image_feature !== undefined && icon.image_feature !== null && icon.image_feature !== '')
        imageFeature = icon.image_feature;
    let $icon = `<img class="image-item-select" src="${imageFeature}" />${icon.text}`
    return $icon;
}