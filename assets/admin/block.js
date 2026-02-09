(function (wp) {
    "use strict";

    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var __ = wp.i18n.__;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var SelectControl = wp.components.SelectControl;
    var ServerSideRender = wp.serverSideRender;

    registerBlockType("simple-notice/notice-button", {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            return [
                el(
                    InspectorControls,
                    { key: "controls" },
                    el(
                        PanelBody,
                        { title: __("Simple Notice", "smn_notice"), initialOpen: true },
                        el(TextControl, {
                            label: __("Button text", "smn_notice"),
                            value: attributes.text,
                            onChange: function (value) {
                                setAttributes({ text: value });
                            }
                        }),
                        el(TextControl, {
                            label: __("Button URL", "smn_notice"),
                            value: attributes.url,
                            onChange: function (value) {
                                setAttributes({ url: value });
                            }
                        }),
                        el(TextControl, {
                            label: __("CSS class", "smn_notice"),
                            value: attributes.class,
                            onChange: function (value) {
                                setAttributes({ class: value });
                            }
                        }),
                        el(SelectControl, {
                            label: __("Hide behavior", "smn_notice"),
                            value: attributes.hide,
                            options: [
                                { label: __("Auto hide", "smn_notice"), value: "auto" },
                                { label: __("Click to hide", "smn_notice"), value: "click" }
                            ],
                            onChange: function (value) {
                                setAttributes({ hide: value });
                            }
                        }),
                        el(SelectControl, {
                            label: __("Position", "smn_notice"),
                            value: attributes.position,
                            options: [
                                { label: __("Top Left", "smn_notice"), value: "left top" },
                                { label: __("Top Center", "smn_notice"), value: "top center" },
                                { label: __("Top Right", "smn_notice"), value: "top right" },
                                { label: __("Left Middle", "smn_notice"), value: "left middle" },
                                { label: __("Right Middle", "smn_notice"), value: "right middle" },
                                { label: __("Bottom Left", "smn_notice"), value: "left bottom" },
                                { label: __("Bottom Center", "smn_notice"), value: "bottom center" },
                                { label: __("Bottom Right", "smn_notice"), value: "right bottom" }
                            ],
                            onChange: function (value) {
                                setAttributes({ position: value });
                            }
                        }),
                        el(SelectControl, {
                            label: __("Style", "smn_notice"),
                            value: attributes.style,
                            options: [
                                { label: __("Bootstrap", "smn_notice"), value: "bootstrap" },
                                { label: __("Happy Blue", "smn_notice"), value: "happyblue" },
                                { label: __("Black BG", "smn_notice"), value: "blackBg" }
                            ],
                            onChange: function (value) {
                                setAttributes({ style: value });
                            }
                        })
                    )
                ),
                el(ServerSideRender, {
                    key: "preview",
                    block: "simple-notice/notice-button",
                    attributes: attributes
                })
            ];
        },
        save: function () {
            return null;
        }
    });
})(window.wp);
