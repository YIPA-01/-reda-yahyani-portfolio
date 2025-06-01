import { ref } from 'vue'

const theme = ref('light')

export function useTheme() {
  function setTheme(newTheme) {
    theme.value = newTheme
  }

  return {
    theme,
    setTheme
  }
} 