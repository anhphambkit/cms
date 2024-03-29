import {Helpers} from '../Helpers/Helpers';
import {ActionsService} from '../Services/ActionsService';

export class MediaList {
    constructor() {
        this.group = {};
        this.group.list = $('#rv_media_items_list').html();
        this.group.tiles = $('#rv_media_items_tiles').html();

        this.item = {};
        this.item.list = $('#rv_media_items_list_element').html();
        this.item.tiles = $('#rv_media_items_tiles_element').html();

        this.$groupContainer = $('.rv-media-items');
    }


    renderData(data, reload = false, load_more_file = false) {
        let _self = this;
        let MediaConfig = Helpers.getConfigs();
        let template = _self.group[Helpers.getRequestParams().view_type];

        let view_in = Helpers.getRequestParams().view_in;

        if (!_.contains(['my_media', 'public', 'trash', 'favorites', 'shared', 'shared_with_me', 'recent'], view_in)) {
            view_in = 'my_media';
        }

        template = template
            .replace(/__noItemIcon__/gi, RV_MEDIA_CONFIG.translations.no_item[view_in].icon || '')
            .replace(/__noItemTitle__/gi, RV_MEDIA_CONFIG.translations.no_item[view_in].title || '')
            .replace(/__noItemMessage__/gi, RV_MEDIA_CONFIG.translations.no_item[view_in].message || '');

        let $result = $(template);
        let $itemsWrapper = $result.find('ul');

        if (load_more_file && this.$groupContainer.find('.rv-media-grid ul').length > 0) {
            $itemsWrapper = this.$groupContainer.find('.rv-media-grid ul')
        }

        if (_.size(data.folders) > 0 || _.size(data.files) > 0) {
            $('.rv-media-items').addClass('has-items');
        } else {
            $('.rv-media-items').removeClass('has-items');
        }

        _.forEach(data.folders, function (value, index) {
            let item = _self.item[Helpers.getRequestParams().view_type];
            item = item
                .replace(/__type__/gi, 'folder')
                .replace(/__id__/gi, value.id)
                .replace(/__name__/gi, value.name || '')
                .replace(/__size__/gi, '')
                .replace(/__date__/gi, value.created_at || '')
                .replace(/__thumb__/gi, '<i class="far fa-folder"></i>');
            let $item = $(item);
            _.forEach(value, function (val, index) {
                $item.data(index, val);
            });
            $item.data('is_folder', true);
            $item.data('icon', MediaConfig.icons.folder);
            $itemsWrapper.append($item);
        });

        _.forEach(data.files, function (value) {
            let item = _self.item[Helpers.getRequestParams().view_type];
            item = item
                .replace(/__type__/gi, 'file')
                .replace(/__id__/gi, value.id)
                .replace(/__name__/gi, value.name || '')
                .replace(/__size__/gi, value.size || '')
                .replace(/__date__/gi, value.created_at || '');
            if (Helpers.getRequestParams().view_type === 'list') {
                item = item
                    .replace(/__thumb__/gi, '<i class="' + value.icon + '"></i>');
            } else {
                switch (value.mime_type) {
                    case 'youtube':
                        item = item
                            .replace(/__thumb__/gi, '<img src="' + value.options.thumb + '" alt="' + value.name + '">');
                        break;
                    default:
                        item = item
                            .replace(/__thumb__/gi, value.thumb ? '<img src="' + value.thumb + '" alt="' + value.name + '">' : '<i class="' + value.icon + '"></i>');
                        break;
                }
            }
            let $item = $(item);
            $item.data('is_folder', false);
            _.forEach(value, function (val, index) {
                $item.data(index, val);
            });
            $itemsWrapper.append($item);
        });
        if (reload !== false) {
            _self.$groupContainer.empty();
        }

        if (load_more_file && this.$groupContainer.find('.rv-media-grid ul').length > 0) {

        } else {
            _self.$groupContainer.append($result);
        }
        _self.$groupContainer.find('.loading-wrapper').remove();
        ActionsService.handleDropdown();

        //trigger event click for file selected
        $('.js-media-list-title[data-id=' + data.selected_file_id + ']').trigger('click');
    }
}
