<h3 class="text-2xl font-semibold leading-none tracking-tight">User Activity</h3>
<p class="text-sm text-muted-foreground">View user activity and engagement.</p>
<div class="p-6 pt-0">
    <div class="relative w-full overflow-auto">
        <table class="w-full caption-bottom text-sm">
            <thead class="tr:border-b font-bold">
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <th
                        class="font-bold h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                        Name
                    </th>
                    <th
                        class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                        Email
                    </th>
                </tr>
            </thead>
            <tbody class="[&amp;_tr:last-child]:border-0">
                <?php foreach ($users as $user) { ?>
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                            <div class="flex items-center gap-3">
                                <div class="grid gap-0.5 text-sm">
                                    <div class="font-medium"><?= $user->name ?></div>
                                </div>
                            </div>
                        </td>
                        <!-- Change this to anything else -->
                        <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><?= $user->password ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>