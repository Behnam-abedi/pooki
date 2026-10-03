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
      desktopAspectRatio: {
        type: "string",
        default: "21/9"
      },
      mobileAspectRatio: {
        type: "string",
        default: "1/1"
      },
      autoplayDelay: {
        type: "number",
        default: 5e3
      },
      arrowColor: {
        type: "string",
        default: "#ffffff"
      },
      paginationColor: {
        type: "string",
        default: "#ec4899"
      }
    },
    textdomain: "pooki",
    editorScript: "file:./build/index.js",
    render: "file:./render.php"
  };

  // blocks/hero-slider/src/index.jsx
  (0, import_blocks.registerBlockType)(block_default.name, {
    edit: ({ attributes, setAttributes }) => {
      const { slides, desktopAspectRatio, mobileAspectRatio, autoplayDelay, arrowColor, paginationColor } = attributes;
      const [activeSlide, setActiveSlide] = (0, import_element.useState)(null);
      const updateSlide = (index, key, value) => {
        const newSlides = [...slides];
        newSlides[index][key] = value;
        setAttributes({ slides: newSlides });
      };
      const addSlide = () => {
        const newSlides = [
          ...slides,
          {
            id: Date.now().toString(),
            imageId: 0,
            imageUrl: "",
            linkUrl: "",
            altText: ""
          }
        ];
        setAttributes({ slides: newSlides });
        setActiveSlide(newSlides.length - 1);
      };
      const removeSlide = (index) => {
        const newSlides = [...slides];
        newSlides.splice(index, 1);
        setAttributes({ slides: newSlides });
        if (activeSlide === index) setActiveSlide(null);
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
        setActiveSlide(targetIndex);
      };
      return /* @__PURE__ */ wp.element.createElement("div", { className: "pooki-hero-slider-editor" }, /* @__PURE__ */ wp.element.createElement(import_block_editor.InspectorControls, null, /* @__PURE__ */ wp.element.createElement(import_components.PanelBody, { title: (0, import_i18n.__)("Slider Settings", "pooki") }, /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Desktop Aspect Ratio (e.g. 21/9, 16/9, auto)", "pooki"),
          value: desktopAspectRatio,
          onChange: (val) => setAttributes({ desktopAspectRatio: val })
        }
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Mobile Aspect Ratio (e.g. 1/1, 4/3, auto)", "pooki"),
          value: mobileAspectRatio,
          onChange: (val) => setAttributes({ mobileAspectRatio: val })
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
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Arrows Color", "pooki"),
          value: arrowColor,
          onChange: (val) => setAttributes({ arrowColor: val })
        }
      ), /* @__PURE__ */ wp.element.createElement(
        import_components.TextControl,
        {
          label: (0, import_i18n.__)("Pagination Color", "pooki"),
          value: paginationColor,
          onChange: (val) => setAttributes({ paginationColor: val })
        }
      ))), /* @__PURE__ */ wp.element.createElement("div", { style: { padding: "20px", background: "#f9fafb", border: "1px solid #e5e7eb", borderRadius: "8px" } }, /* @__PURE__ */ wp.element.createElement("div", { style: { display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: "20px" } }, /* @__PURE__ */ wp.element.createElement("h3", { style: { margin: 0, fontSize: "18px", fontWeight: "bold" } }, (0, import_i18n.__)("Hero Slider", "pooki")), /* @__PURE__ */ wp.element.createElement(import_components.Button, { isPrimary: true, onClick: addSlide }, (0, import_i18n.__)("Add New Slide", "pooki"))), slides.length === 0 && /* @__PURE__ */ wp.element.createElement(import_components.Notice, { status: "info", isDismissible: false }, (0, import_i18n.__)('No slides added yet. Click "Add New Slide" to begin.', "pooki")), slides.map((slide, index) => {
        const isActive = activeSlide === index;
        return /* @__PURE__ */ wp.element.createElement("div", { key: slide.id, style: { background: "#fff", marginBottom: "10px", border: "1px solid #e5e7eb", borderRadius: "6px", overflow: "hidden" } }, /* @__PURE__ */ wp.element.createElement(
          "div",
          {
            style: { padding: "12px 15px", display: "flex", justifyContent: "space-between", alignItems: "center", cursor: "pointer", background: isActive ? "#f3f4f6" : "#fff", borderBottom: isActive ? "1px solid #e5e7eb" : "none" },
            onClick: () => setActiveSlide(isActive ? null : index)
          },
          /* @__PURE__ */ wp.element.createElement("div", { style: { display: "flex", alignItems: "center", gap: "10px" } }, /* @__PURE__ */ wp.element.createElement("strong", { style: { fontSize: "14px" } }, (0, import_i18n.__)("Slide", "pooki"), " ", index + 1), slide.imageUrl && /* @__PURE__ */ wp.element.createElement("img", { src: slide.imageUrl, style: { width: "40px", height: "24px", objectFit: "cover", borderRadius: "4px" } })),
          /* @__PURE__ */ wp.element.createElement("div", { style: { display: "flex", gap: "4px" }, onClick: (e) => e.stopPropagation() }, /* @__PURE__ */ wp.element.createElement(import_components.Button, { isSmall: true, disabled: index === 0, onClick: () => moveSlide(index, "up") }, (0, import_i18n.__)("Up", "pooki")), /* @__PURE__ */ wp.element.createElement(import_components.Button, { isSmall: true, disabled: index === slides.length - 1, onClick: () => moveSlide(index, "down") }, (0, import_i18n.__)("Down", "pooki")), /* @__PURE__ */ wp.element.createElement(import_components.Button, { isSmall: true, isDestructive: true, onClick: () => removeSlide(index) }, (0, import_i18n.__)("Remove", "pooki")))
        ), isActive && /* @__PURE__ */ wp.element.createElement("div", { style: { padding: "20px" } }, /* @__PURE__ */ wp.element.createElement("div", { style: { marginBottom: "15px" } }, /* @__PURE__ */ wp.element.createElement("p", { style: { margin: "0 0 8px 0", fontSize: "13px", fontWeight: "600" } }, (0, import_i18n.__)("Slide Image", "pooki")), /* @__PURE__ */ wp.element.createElement(import_block_editor.MediaUploadCheck, null, /* @__PURE__ */ wp.element.createElement(
          import_block_editor.MediaUpload,
          {
            onSelect: (media) => {
              updateSlide(index, "imageId", media.id);
              updateSlide(index, "imageUrl", media.url);
              if (!slide.altText && media.alt) {
                updateSlide(index, "altText", media.alt);
              }
            },
            allowedTypes: ["image"],
            value: slide.imageId,
            render: ({ open }) => /* @__PURE__ */ wp.element.createElement("div", { onClick: open, style: { cursor: "pointer", background: "#f3f4f6", height: "160px", display: "flex", alignItems: "center", justifyContent: "center", borderRadius: "6px", overflow: "hidden", border: "1px dashed #d1d5db" } }, slide.imageUrl ? /* @__PURE__ */ wp.element.createElement("img", { src: slide.imageUrl, style: { width: "100%", height: "100%", objectFit: "contain" } }) : /* @__PURE__ */ wp.element.createElement(import_components.Button, { isSecondary: true }, (0, import_i18n.__)("Select Image", "pooki")))
          }
        ))), /* @__PURE__ */ wp.element.createElement("div", { style: { display: "grid", gridTemplateColumns: "1fr 1fr", gap: "15px" } }, /* @__PURE__ */ wp.element.createElement(
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
        ))));
      })));
    },
    save: () => {
      return null;
    }
  });
})();
