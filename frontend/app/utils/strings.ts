export function slugify(text: string): string {
    return text
        .trim()
        .replaceAll(/\s+/g, ' ')
        .replaceAll(' ', '-')
        .toLowerCase()
}
