<template>
  <span class="whitespace-no-wrap" v-if="!field.shouldHide">
    <span class="status-indicator" :class="{'w-icon': iconSelected}" v-bind="colorClassStyle" v-if="labelText">
      <component v-if="iconSelected" :is="iconSelected"></component>
      {{ labelText }}
    </span>
    <span v-else-if="field.unknownLabel && !field.withoutLabels">{{
        field.unknownLabel
      }}</span>
    <span v-else>-</span>
  </span>
</template>

<script>
import IconCancel from './icons/IconCancel'
import IconError from './icons/IconError'
import IconLoading from './icons/IconLoading'
import IconMinus from './icons/IconMinus'
import IconSuccess from './icons/IconSuccess'

export default {
  props: ["resource", "resourceName", "resourceId", "field"],
  components: {
    'icon-cancel': IconCancel,
    'icon-error': IconError,
    'icon-loading': IconLoading,
    'icon-minus': IconMinus,
    'icon-success': IconSuccess,
  },
  computed: {
    labelText() {
      if (this.field.withoutLabels) {
        return this.field.value;
      } else if (
          this.field.labels &&
          this.field.labels.hasOwnProperty(this.field.value)
      ) {
        return this.field.labels[this.field.value];
      }
    },
    colorClassStyle() {
      let color = "grey";

      if (
          this.field.colors &&
          this.field.colors.hasOwnProperty(this.field.value)
      ) {
        color = this.field.colors[this.field.value];
      }

      if (/^(?:#|var\(--|(?:rgb|hsl)a?\()/.test(color)) {
        return {
          style: `background:${color};`,
        };
      }

      return {
        class: `indicator-${color}`,
      };
    },
    iconSelected() {
      let icon = false;
      if (this.field.icons && this.field.icons.hasOwnProperty(this.field.value)) {
        icon = this.field.icons[this.field.value];
        return icon ? `icon-${icon.toLowerCase()}` : null;
      }
    }
  },
};
</script>
