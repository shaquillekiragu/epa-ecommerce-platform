export function slugify(text: string): string {
    const single_space_text = text.replaceAll(/\s/, '')
    const hyphenated_text = single_space_text.replaceAll(' ', '-')
    return hyphenated_text.toLowerCase()
}
