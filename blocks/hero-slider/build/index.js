(() => {
  var __require = /* @__PURE__ */ ((x) => typeof require !== "undefined" ? require : typeof Proxy !== "undefined" ? new Proxy(x, {
    get: (a, b) => (typeof require !== "undefined" ? require : a)[b]
  }) : x)(function(x) {
    if (typeof require !== "undefined") return require.apply(this, arguments);
    throw Error('Dynamic require of "' + x + '" is not supported');
  });

  // blocks/hero-slider/src/index.jsx
  var import_blocks = wp.blocks;
  var import_i18n = wp.i18n;
  var import_block_editor = wp.blockEditor;
  var import_components = wp.components;
  var import_element = wp.element;

  // blocks/hero-slider/block.json
  var block_default = {
    $schema: "https://schemas.wp.org/trunk/block.json",
    apiVersion: 3,
    name: "pooki/hero-slider",
    version: "1.0.0",
    title: "Pooki Hero Slider",
    category: "design",
    icon: "images-alt2",
    description: "A customizable hero slider with separate desktop and mobile settings.",
    supports: {
      html: false,
      align: ["full", "wide"]
    },
    attributes: {
      slides: {
        type: "array",
        default: []
      },
      desktopHeight: {
        type: "string",
        default: "600px"
      },
      mobileHeight: {
        type: "string",
        default: "400px"
      },
      autoplayDelay: {
        type: "number",
        default: 5e3
      }
    },
    textdomain: "pooki",
    editorScript: "file:./build/index.js",
    render: "file:./render.php"
  };

  // blocks/hero-slider/src/index.jsx
  (0, import_blocks.registerBlockType)(block_default.name, {
    edit: ({ attributes, setAttributes }) => {
      const { slides, desktopHeight, mobileHeight, autoplayDelay } = attributes;
      const updateSlide = (index, key, value) => {
        const newSlides = [...slides];
        newSlides[index][key] = value;
        setAttributes({ slides: newSlides });
      };
      const addSlide = () => {
        setAttributes({
          slides: [
            ...slides,
            {
              id: Date.now().toString(),
              desktopImageId: 0,
              desktopImageUrl: "",
              mobileImageId: 0,
              mobileImageUrl: "",
              linkUrl: "",
              altText: ""
            }
          ]
        });
      };
      const removeSlide = (index) => {
        const newSlides = [...slides];
        newSlides.splice(index, 1);
        setAttributes({ slides: newSlides });
      };
      const moveSlide = (index, direction) => {
        if (direction === "up" && index === 0 || direction === "down" && index === slides.length - 1) {
          return;
        }
        const newSlides = [...slides];
        const targetIndex = direction === "up" ? index - 1 : index + 1;
        const temp = newSlides[index];
        newSlides[index] = newSlides[targetIndex];
        newSlides[targetIndex] = temp;
        setAttributes({ slides: newSlides });
      };
      return /* @__PURE__ */ wp.element.createElement("div", { className: "pooki-hero-slider-editor" }, /* @__PURE__ */ wp.element.createElement(import_block_editor.InspectorControls, null, /* @__PURE__ */ wp.element.createElement(import_components.PanelBody, { title: (0, import_i18n.__)("Slider Settings", "pooki") }, /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Desktop Height (e.g. 600px, 100vh)", "pooki"),
          value: desktopHeight,
          onChange: (val) => setAttributes({ desktopHeight: val })
        }
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Mobile Height (e.g. 400px, 80vh)", "pooki"),
          value: mobileHeight,
          onChange: (val) => setAttributes({ mobileHeight: val })
        }
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.RangeControl,
        {
          label: (0, import_i18n.__)("Autoplay Delay (ms)", "pooki"),
          value: autoplayDelay,
          onChange: (val) => setAttributes({ autoplayDelay: val }),
          min: 1e3,
          max: 1e4,
          step: 500
        }
      ))), /* @__PURE__ */ wp.element.createElement("div", { style: { padding: "20px", background: "#f0f0f0", border: "1px solid #ccc" } }, /* @__PURE__ */ wp.element.createElement("h3", { style: { marginTop: 0 } }, (0, import_i18n.__)("Hero Slider Slides", "pooki")), slides.length === 0 && /* @__PURE__ */ wp.element.createElement(import_components.Notice, { status: "warning", isDismissible: false }, (0, import_i18n.__)('No slides added yet. Click "Add Slide" to begin.', "pooki")), slides.map((slide, index) => /* @__PURE__ */ wp.element.createElement("div", { key: slide.id, style: { background: "#fff", padding: "15px", marginBottom: "15px", border: "1px solid #ddd" } }, /* @__PURE__ */ wp.element.createElement("div", { style: { display: "flex", justifyContent: "space-between", marginBottom: "10px" } }, /* @__PURE__ */ wp.element.createElement("strong", null, (0, import_i18n.__)("Slide", "pooki"), " ", index + 1), /* @__PURE__ */ wp.element.createElement("div", null, /* @__PURE__ */ wp.element.createElement(
        import_components.Button,
        {
          isSmall: true,
          disabled: index === 0,
          onClick: () => moveSlide(index, "up")
        },
        "\u2191"
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.Button,
        {
          isSmall: true,
          disabled: index === slides.length - 1,
          onClick: () => moveSlide(index, "down"),
          style: { marginLeft: "5px" }
        },
        "\u2193"
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.Button,
        {
          isSmall: true,
          isDestructive: true,
          onClick: () => removeSlide(index),
          style: { marginLeft: "10px" }
        },
        (0, import_i18n.__)("Remove", "pooki")
      ))), /* @__PURE__ */ wp.element.createElement("div", { style: { display: "flex", gap: "15px", marginBottom: "15px" } }, /* @__PURE__ */ wp.element.createElement("div", { style: { flex: 1 } }, /* @__PURE__ */ wp.element.createElement("p", { style: { margin: "0 0 5px 0" } }, /* @__PURE__ */ wp.element.createElement("strong", null, (0, import_i18n.__)("Desktop Image", "pooki"))), /* @__PURE__ */ wp.element.createElement(import_block_editor.MediaUploadCheck, null, /* @__PURE__ */ wp.element.createElement(
        import_block_editor.MediaUpload,
        {
          onSelect: (media) => {
            updateSlide(index, "desktopImageId", media.id);
            updateSlide(index, "desktopImageUrl", media.url);
            if (!slide.altText && media.alt) {
              updateSlide(index, "altText", media.alt);
            }
          },
          allowedTypes: ["image"],
          value: slide.desktopImageId,
          render: ({ open }) => /* @__PURE__ */ wp.element.createElement("div", { onClick: open, style: { cursor: "pointer", background: "#eee", height: "100px", display: "flex", alignItems: "center", justifyContent: "center", overflow: "hidden" } }, slide.desktopImageUrl ? /* @__PURE__ */ wp.element.createElement("img", { src: slide.desktopImageUrl, style: { maxWidth: "100%", maxHeight: "100%" } }) : /* @__PURE__ */ wp.element.createElement(import_components.Button, { isSecondary: true }, (0, import_i18n.__)("Select Desktop Image", "pooki")))
        }
      ))), /* @__PURE__ */ wp.element.createElement("div", { style: { flex: 1 } }, /* @__PURE__ */ wp.element.createElement("p", { style: { margin: "0 0 5px 0" } }, /* @__PURE__ */ wp.element.createElement("strong", null, (0, import_i18n.__)("Mobile Image", "pooki"))), /* @__PURE__ */ wp.element.createElement(import_block_editor.MediaUploadCheck, null, /* @__PURE__ */ wp.element.createElement(
        import_block_editor.MediaUpload,
        {
          onSelect: (media) => {
            updateSlide(index, "mobileImageId", media.id);
            updateSlide(index, "mobileImageUrl", media.url);
          },
          allowedTypes: ["image"],
          value: slide.mobileImageId,
          render: ({ open }) => /* @__PURE__ */ wp.element.createElement("div", { onClick: open, style: { cursor: "pointer", background: "#eee", height: "100px", display: "flex", alignItems: "center", justifyContent: "center", overflow: "hidden" } }, slide.mobileImageUrl ? /* @__PURE__ */ wp.element.createElement("img", { src: slide.mobileImageUrl, style: { maxWidth: "100%", maxHeight: "100%" } }) : /* @__PURE__ */ wp.element.createElement(import_components.Button, { isSecondary: true }, (0, import_i18n.__)("Select Mobile Image", "pooki")))
        }
      )))), /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Link URL (optional)", "pooki"),
          value: slide.linkUrl,
          onChange: (val) => updateSlide(index, "linkUrl", val)
        }
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Alt Text", "pooki"),
          value: slide.altText,
          onChange: (val) => updateSlide(index, "altText", val)
        }
      ))), /* @__PURE__ */ wp.element.createElement(import_components.Button, { isPrimary: true, onClick: addSlide }, (0, import_i18n.__)("Add Slide", "pooki"))));
    },
    save: () => {
      return null;
    }
  });
})();
